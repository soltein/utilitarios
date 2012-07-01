<?php
/**
 * Faz consulta ao webservice do banco central e retorna o IGP-M atual
 * @author Julio Cezar - <julio@soltein.com.br>
 */
class SOAP extends SOAPClient {

    private static $instance;

    private function SOAP($url) {
        return parent::__construct($url);
    }

    public static function getInstance($dados) {
        if (empty(self::$instance))
            self::$instance = new SOAP($dados);

        return self::$instance;
    }

    public function call($configuracoes) {
        return parent::__soapCall($configuracoes[0], $configuracoes[1]);
    }

}

class IGPM {
    private $url = "https://www3.bcb.gov.br/sgspub/JSP/sgsgeral/FachadaWSSGS.wsdl";
    
    /**
     *Função para acessar soap
     * @access public
     * @param array contendo os itens necessários para o retorno do webservice
     * @return objeto XML 
     */
    public function soap($conf){
        $cliente = SOAP::getInstance($this->url);

        $resultado = $cliente->call($conf);
        return simplexml_load_string($resultado);        
    }
   
    /**
     *Soma o indice dos ultimos 12 meses
     * @access public
     * @param type XML retornado da função soap
     * @return A soma dos indices
     */
    public function somaUltimos12Meses($xml){
        $soma = 0;
        foreach ($xml->SERIE->ITEM as $item) {
            $soma += (float) $item->VALOR;
        }

        return $soma;        
    }
    /**
     *
     * @param type XML retornado da função soap
     * @return O ultimo indíce convertido em float.
     */
    public function converterIndiceFloat($xml){
        /**
         * O valor será retornado como X.XXX,XX se usar o number_format, ou mesmo converter direto para float
         * o mesmo será truncado para baixo. Neste caso substituir o . da milhar por vazio e a , por ponto de modo a converter considerando
         * as casas decimais.
         */        
        return ((float) str_replace(",", ".", str_replace(".", "", (string) $xml->SERIE->VALOR)));       
    }    

    /**
     *
     * @return type XML contendo o ultimo indice do IGP-M
     */
    public function getUltimoIndiceXML() {
        $conf[0] = 'getUltimoValorXML';
        $conf[1] = array('codigoSerie' => 189);

       
        return $this->soap($conf);
    }

    /**
     *
     * @return type Os indices dos ultimos 12 meses em formato XML
     */
    public function getUltimos12Meses() {
        $mes = date('m');
        $ano = date('Y');

        $dataInicio = date("d/m/Y", strtotime("-12 month", mktime(0, 0, 0, $mes, 01, $ano)));
        $dataFim = date("d/m/Y", mktime(0, 0, 0, $mes + 1, 0, $ano));
        
        $conf[0] = 'getValoresSeriesXML';
        $conf[1] = array('codigoSeries' => array(189), 'dataInicio' => $dataInicio, 'dataFim' => $dataFim);

        return $this->soap($conf);
    }
}


/**
 * Teste das classes acima.
 */
echo "<pre>";

$teste_igpm = new IGPM();

$xml_indice = $teste_igpm->getUltimoIndiceXML();

echo "<br />--------------XML ULTIMO INDICE---------------<br />";

print_r($xml_indice);
echo "<br />";
echo "<br />--------------VALOR ULTIMO INDICE---------------<br />";
echo $teste_igpm->converterIndiceFloat($xml_indice);

echo "<br />";

echo "<br />--------------XML ULTIMO 12 MESES---------------<br />";

$xml_12_ult_indice = $teste_igpm->getUltimos12Meses();

print_r($xml_12_ult_indice);
echo "<br />--------------SOMA 12 MESES---------------<br />";
echo $teste_igpm->somaUltimos12Meses($xml_12_ult_indice);
?>