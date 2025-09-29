<?php

/* notacr2.1.xml.twig */
class __TwigTemplate_41e1409ae2480d139554188f5917bc94851d670dd426aac3083197184d587968 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"no\"?>
<CreditNote xmlns=\"urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2\"
            xmlns:cac=\"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2\"
            xmlns:cbc=\"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2\"
            xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\"
            xmlns:ext=\"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2\">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>2.0</cbc:CustomizationID>
    <cbc:ID>";
        // line 14
        echo $this->getAttribute(($context["doc"] ?? null), "serie", array());
        echo "-";
        echo $this->getAttribute(($context["doc"] ?? null), "correlativo", array());
        echo "</cbc:ID>
    <cbc:IssueDate>";
        // line 15
        echo twig_date_format_filter($this->env, $this->getAttribute(($context["doc"] ?? null), "fechaEmision", array()), "Y-m-d");
        echo "</cbc:IssueDate>
    <cbc:IssueTime>";
        // line 16
        echo twig_date_format_filter($this->env, $this->getAttribute(($context["doc"] ?? null), "fechaEmision", array()), "H:i:s");
        echo "</cbc:IssueTime>
    ";
        // line 17
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "legends", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["leg"]) {
            // line 18
            echo "<cbc:Note languageLocaleID=\"";
            echo $this->getAttribute($context["leg"], "code", array());
            echo "\"><![CDATA[";
            echo $this->getAttribute($context["leg"], "value", array());
            echo "]]></cbc:Note>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['leg'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        echo "<cbc:DocumentCurrencyCode>";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "</cbc:DocumentCurrencyCode>
    <cac:DiscrepancyResponse>
        <cbc:ReferenceID>";
        // line 22
        echo $this->getAttribute(($context["doc"] ?? null), "numDocfectado", array());
        echo "</cbc:ReferenceID>
        <cbc:ResponseCode>";
        // line 23
        echo $this->getAttribute(($context["doc"] ?? null), "codMotivo", array());
        echo "</cbc:ResponseCode>
        <cbc:Description>";
        // line 24
        echo $this->getAttribute(($context["doc"] ?? null), "desMotivo", array());
        echo "</cbc:Description>
    </cac:DiscrepancyResponse>
    ";
        // line 26
        if ($this->getAttribute(($context["doc"] ?? null), "compra", array())) {
            // line 27
            echo "<cac:OrderReference>
        <cbc:ID>";
            // line 28
            echo $this->getAttribute(($context["doc"] ?? null), "compra", array());
            echo "</cbc:ID>
    </cac:OrderReference>
    ";
        }
        // line 31
        echo "<cac:BillingReference>
        <cac:InvoiceDocumentReference>
            <cbc:ID>";
        // line 33
        echo $this->getAttribute(($context["doc"] ?? null), "numDocfectado", array());
        echo "</cbc:ID>
            <cbc:DocumentTypeCode>";
        // line 34
        echo $this->getAttribute(($context["doc"] ?? null), "tipDocAfectado", array());
        echo "</cbc:DocumentTypeCode>
        </cac:InvoiceDocumentReference>
    </cac:BillingReference>
    ";
        // line 37
        if ($this->getAttribute(($context["doc"] ?? null), "guias", array())) {
            // line 38
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "guias", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["guia"]) {
                // line 39
                echo "<cac:DespatchDocumentReference>
        <cbc:ID>";
                // line 40
                echo $this->getAttribute($context["guia"], "nroDoc", array());
                echo "</cbc:ID>
        <cbc:DocumentTypeCode>";
                // line 41
                echo $this->getAttribute($context["guia"], "tipoDoc", array());
                echo "</cbc:DocumentTypeCode>
    </cac:DespatchDocumentReference>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['guia'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 45
        if ($this->getAttribute(($context["doc"] ?? null), "relDocs", array())) {
            // line 46
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "relDocs", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["rel"]) {
                // line 47
                echo "<cac:AdditionalDocumentReference>
        <cbc:ID>";
                // line 48
                echo $this->getAttribute($context["rel"], "nroDoc", array());
                echo "</cbc:ID>
        <cbc:DocumentTypeCode>";
                // line 49
                echo $this->getAttribute($context["rel"], "tipoDoc", array());
                echo "</cbc:DocumentTypeCode>
    </cac:AdditionalDocumentReference>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rel'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 53
        $context["emp"] = $this->getAttribute(($context["doc"] ?? null), "company", array());
        // line 54
        echo "<cac:Signature>
        <cbc:ID>";
        // line 55
        echo $this->getAttribute(($context["emp"] ?? null), "ruc", array());
        echo "</cbc:ID>
        <cbc:Note>GREENTER</cbc:Note>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>";
        // line 59
        echo $this->getAttribute(($context["emp"] ?? null), "ruc", array());
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[";
        // line 62
        echo $this->getAttribute(($context["emp"] ?? null), "nombreComercial", array());
        echo "]]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#SIGN-GREEN</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    <cac:AccountingSupplierParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"6\">";
        // line 74
        echo $this->getAttribute(($context["emp"] ?? null), "ruc", array());
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[";
        // line 77
        echo $this->getAttribute(($context["emp"] ?? null), "nombreComercial", array());
        echo "]]></cbc:Name>
            </cac:PartyName>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
        // line 80
        echo $this->getAttribute(($context["emp"] ?? null), "razonSocial", array());
        echo "]]></cbc:RegistrationName>
                ";
        // line 81
        $context["addr"] = $this->getAttribute(($context["emp"] ?? null), "address", array());
        // line 82
        echo "<cac:RegistrationAddress>
                    <cbc:ID>";
        // line 83
        echo $this->getAttribute(($context["addr"] ?? null), "ubigueo", array());
        echo "</cbc:ID>
                    <cbc:AddressTypeCode>";
        // line 84
        echo $this->getAttribute(($context["addr"] ?? null), "codLocal", array());
        echo "</cbc:AddressTypeCode>
                    ";
        // line 85
        if ($this->getAttribute(($context["addr"] ?? null), "urbanizacion", array())) {
            // line 86
            echo "<cbc:CitySubdivisionName>";
            echo $this->getAttribute(($context["addr"] ?? null), "urbanizacion", array());
            echo "</cbc:CitySubdivisionName>
                    ";
        }
        // line 88
        echo "<cbc:CityName>";
        echo $this->getAttribute(($context["addr"] ?? null), "provincia", array());
        echo "</cbc:CityName>
                    <cbc:CountrySubentity>";
        // line 89
        echo $this->getAttribute(($context["addr"] ?? null), "departamento", array());
        echo "</cbc:CountrySubentity>
                    <cbc:District>";
        // line 90
        echo $this->getAttribute(($context["addr"] ?? null), "distrito", array());
        echo "</cbc:District>
                    <cac:AddressLine>
                        <cbc:Line><![CDATA[";
        // line 92
        echo $this->getAttribute(($context["addr"] ?? null), "direccion", array());
        echo "]]></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>";
        // line 95
        echo $this->getAttribute(($context["addr"] ?? null), "codigoPais", array());
        echo "</cbc:IdentificationCode>
                    </cac:Country>
                </cac:RegistrationAddress>
            </cac:PartyLegalEntity>
            ";
        // line 99
        if (($this->getAttribute(($context["emp"] ?? null), "email", array()) || $this->getAttribute(($context["emp"] ?? null), "telephone", array()))) {
            // line 100
            echo "<cac:Contact>
                    ";
            // line 101
            if ($this->getAttribute(($context["emp"] ?? null), "telephone", array())) {
                // line 102
                echo "<cbc:Telephone>";
                echo $this->getAttribute(($context["emp"] ?? null), "telephone", array());
                echo "</cbc:Telephone>
                    ";
            }
            // line 104
            if ($this->getAttribute(($context["emp"] ?? null), "email", array())) {
                // line 105
                echo "<cbc:ElectronicMail>";
                echo $this->getAttribute(($context["emp"] ?? null), "email", array());
                echo "</cbc:ElectronicMail>
                    ";
            }
            // line 107
            echo "</cac:Contact>
            ";
        }
        // line 109
        echo "</cac:Party>
    </cac:AccountingSupplierParty>
    ";
        // line 111
        $context["client"] = $this->getAttribute(($context["doc"] ?? null), "client", array());
        // line 112
        echo "<cac:AccountingCustomerParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"";
        // line 115
        echo $this->getAttribute(($context["client"] ?? null), "tipoDoc", array());
        echo "\">";
        echo $this->getAttribute(($context["client"] ?? null), "numDoc", array());
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
        // line 118
        echo $this->getAttribute(($context["client"] ?? null), "rznSocial", array());
        echo "]]></cbc:RegistrationName>
                ";
        // line 119
        if ($this->getAttribute(($context["client"] ?? null), "address", array())) {
            // line 120
            $context["addr"] = $this->getAttribute(($context["client"] ?? null), "address", array());
            // line 121
            echo "<cac:RegistrationAddress>
                        ";
            // line 122
            if ($this->getAttribute(($context["addr"] ?? null), "ubigueo", array())) {
                // line 123
                echo "<cbc:ID>";
                echo $this->getAttribute(($context["addr"] ?? null), "ubigueo", array());
                echo "</cbc:ID>
                        ";
            }
            // line 125
            echo "<cac:AddressLine>
                            <cbc:Line><![CDATA[";
            // line 126
            echo $this->getAttribute(($context["addr"] ?? null), "direccion", array());
            echo "]]></cbc:Line>
                        </cac:AddressLine>
                        <cac:Country>
                            <cbc:IdentificationCode>";
            // line 129
            echo $this->getAttribute(($context["addr"] ?? null), "codigoPais", array());
            echo "</cbc:IdentificationCode>
                        </cac:Country>
                    </cac:RegistrationAddress>
                ";
        }
        // line 133
        echo "</cac:PartyLegalEntity>
            ";
        // line 134
        if (($this->getAttribute(($context["client"] ?? null), "email", array()) || $this->getAttribute(($context["client"] ?? null), "telephone", array()))) {
            // line 135
            echo "<cac:Contact>
                    ";
            // line 136
            if ($this->getAttribute(($context["client"] ?? null), "telephone", array())) {
                // line 137
                echo "<cbc:Telephone>";
                echo $this->getAttribute(($context["client"] ?? null), "telephone", array());
                echo "</cbc:Telephone>
                    ";
            }
            // line 139
            if ($this->getAttribute(($context["client"] ?? null), "email", array())) {
                // line 140
                echo "<cbc:ElectronicMail>";
                echo $this->getAttribute(($context["client"] ?? null), "email", array());
                echo "</cbc:ElectronicMail>
                    ";
            }
            // line 142
            echo "</cac:Contact>
            ";
        }
        // line 144
        echo "</cac:Party>
    </cac:AccountingCustomerParty>
    <cac:TaxTotal>
        <cbc:TaxAmount currencyID=\"";
        // line 147
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "totalImpuestos", array())));
        echo "</cbc:TaxAmount>
        ";
        // line 148
        if ($this->getAttribute(($context["doc"] ?? null), "mtoISC", array())) {
            // line 149
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 150
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoBaseIsc", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 151
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoISC", array())));
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>2000</cbc:ID>
                        <cbc:Name>ISC</cbc:Name>
                        <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 161
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperGravadas", array())) {
            // line 162
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 163
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperGravadas", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 164
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoIGV", array())));
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>1000</cbc:ID>
                        <cbc:Name>IGV</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 174
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperInafectas", array())) {
            // line 175
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 176
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperInafectas", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 177
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">0</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9998</cbc:ID>
                        <cbc:Name>INA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 187
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperExoneradas", array())) {
            // line 188
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 189
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperExoneradas", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 190
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">0</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9997</cbc:ID>
                        <cbc:Name>EXO</cbc:Name>
                        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 200
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperGratuitas", array())) {
            // line 201
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 202
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperGratuitas", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 203
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">0</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9996</cbc:ID>
                        <cbc:Name>GRA</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 213
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperExportacion", array())) {
            // line 214
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 215
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperExportacion", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 216
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">0</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9995</cbc:ID>
                        <cbc:Name>EXP</cbc:Name>
                        <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 226
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOtrosTributos", array())) {
            // line 227
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 228
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoBaseOth", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 229
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOtrosTributos", array())));
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cac:TaxScheme>
                        <cbc:ID>9999</cbc:ID>
                        <cbc:Name>OTROS</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        ";
        }
        // line 239
        echo "</cac:TaxTotal>
    <cac:LegalMonetaryTotal>
        ";
        // line 241
        if ($this->getAttribute(($context["doc"] ?? null), "sumOtrosCargos", array())) {
            // line 242
            echo "<cbc:ChargeTotalAmount currencyID=\"";
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "sumOtrosCargos", array())));
            echo "</cbc:ChargeTotalAmount>
        ";
        }
        // line 244
        echo "<cbc:PayableAmount currencyID=\"";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoImpVenta", array())));
        echo "</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>
    ";
        // line 246
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "details", array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["detail"]) {
            // line 247
            echo "<cac:CreditNoteLine>
        <cbc:ID>";
            // line 248
            echo $this->getAttribute($context["loop"], "index", array());
            echo "</cbc:ID>
        <cbc:CreditedQuantity unitCode=\"";
            // line 249
            echo $this->getAttribute($context["detail"], "unidad", array());
            echo "\">";
            echo $this->getAttribute($context["detail"], "cantidad", array());
            echo "</cbc:CreditedQuantity>
        <cbc:LineExtensionAmount currencyID=\"";
            // line 250
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoValorVenta", array())));
            echo "</cbc:LineExtensionAmount>
        <cac:PricingReference>
            ";
            // line 252
            if ($this->getAttribute($context["detail"], "mtoPrecioUnitario", array())) {
                // line 253
                echo "<cac:AlternativeConditionPrice>
                <cbc:PriceAmount currencyID=\"";
                // line 254
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoPrecioUnitario", array()), 6));
                echo "</cbc:PriceAmount>
                <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
            </cac:AlternativeConditionPrice>
            ";
            }
            // line 258
            if ($this->getAttribute($context["detail"], "mtoValorGratuito", array())) {
                // line 259
                echo "<cac:AlternativeConditionPrice>
                <cbc:PriceAmount currencyID=\"";
                // line 260
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoValorGratuito", array()), 6));
                echo "</cbc:PriceAmount>
                <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
            </cac:AlternativeConditionPrice>
            ";
            }
            // line 264
            echo "</cac:PricingReference>
        <cac:TaxTotal>
            <cbc:TaxAmount currencyID=\"";
            // line 266
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "totalImpuestos", array())));
            echo "</cbc:TaxAmount>
            ";
            // line 267
            if ($this->getAttribute($context["detail"], "isc", array())) {
                // line 268
                echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
                // line 269
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoBaseIsc", array())));
                echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
                // line 270
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "isc", array())));
                echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
                // line 272
                echo $this->getAttribute($context["detail"], "porcentajeIsc", array());
                echo "</cbc:Percent>
                    <cbc:TierRange>";
                // line 273
                echo $this->getAttribute($context["detail"], "tipSisIsc", array());
                echo "</cbc:TierRange>
                    <cac:TaxScheme>
                        <cbc:ID>2000</cbc:ID>
                        <cbc:Name>ISC</cbc:Name>
                        <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            }
            // line 282
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 283
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoBaseIgv", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 284
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "igv", array())));
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
            // line 286
            echo $this->getAttribute($context["detail"], "porcentajeIgv", array());
            echo "</cbc:Percent>
                    <cbc:TaxExemptionReasonCode>";
            // line 287
            echo $this->getAttribute($context["detail"], "tipAfeIgv", array());
            echo "</cbc:TaxExemptionReasonCode>
                    ";
            // line 288
            $context["afect"] = Greenter\Xml\Filter\TributoFunction::getByAfectacion($this->getAttribute($context["detail"], "tipAfeIgv", array()));
            // line 289
            echo "<cac:TaxScheme>
                        <cbc:ID>";
            // line 290
            echo $this->getAttribute(($context["afect"] ?? null), "id", array());
            echo "</cbc:ID>
                        <cbc:Name>";
            // line 291
            echo $this->getAttribute(($context["afect"] ?? null), "name", array());
            echo "</cbc:Name>
                        <cbc:TaxTypeCode>";
            // line 292
            echo $this->getAttribute(($context["afect"] ?? null), "code", array());
            echo "</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            // line 296
            if ($this->getAttribute($context["detail"], "otroTributo", array())) {
                // line 297
                echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
                // line 298
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoBaseOth", array())));
                echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
                // line 299
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "otroTributo", array())));
                echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
                // line 301
                echo $this->getAttribute($context["detail"], "porcentajeOth", array());
                echo "</cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID>9999</cbc:ID>
                        <cbc:Name>OTROS</cbc:Name>
                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            }
            // line 310
            echo "</cac:TaxTotal>
        <cac:Item>
            <cbc:Description><![CDATA[";
            // line 312
            echo $this->getAttribute($context["detail"], "descripcion", array());
            echo "]]></cbc:Description>
            ";
            // line 313
            if ($this->getAttribute($context["detail"], "codProducto", array())) {
                // line 314
                echo "<cac:SellersItemIdentification>
                    <cbc:ID>";
                // line 315
                echo $this->getAttribute($context["detail"], "codProducto", array());
                echo "</cbc:ID>
                </cac:SellersItemIdentification>
            ";
            }
            // line 318
            if ($this->getAttribute($context["detail"], "codProdSunat", array())) {
                // line 319
                echo "<cac:CommodityClassification>
                    <cbc:ItemClassificationCode>";
                // line 320
                echo $this->getAttribute($context["detail"], "codProdSunat", array());
                echo "</cbc:ItemClassificationCode>
                </cac:CommodityClassification>
            ";
            }
            // line 323
            if ($this->getAttribute($context["detail"], "codProdGS1", array())) {
                // line 324
                echo "<cac:StandardItemIdentification>
                    <cbc:ID>";
                // line 325
                echo $this->getAttribute($context["detail"], "codProdGS1", array());
                echo "</cbc:ID>
                </cac:StandardItemIdentification>
            ";
            }
            // line 328
            if ($this->getAttribute($context["detail"], "atributos", array())) {
                // line 329
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["detail"], "atributos", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["atr"]) {
                    // line 330
                    echo "<cac:AdditionalItemProperty >
                        <cbc:Name>";
                    // line 331
                    echo $this->getAttribute($context["atr"], "name", array());
                    echo "</cbc:Name>
                        <cbc:NameCode>";
                    // line 332
                    echo $this->getAttribute($context["atr"], "code", array());
                    echo "</cbc:NameCode>
                        ";
                    // line 333
                    if ($this->getAttribute($context["atr"], "value", array())) {
                        // line 334
                        echo "<cbc:Value>";
                        echo $this->getAttribute($context["atr"], "value", array());
                        echo "</cbc:Value>
                        ";
                    }
                    // line 336
                    if ((($this->getAttribute($context["atr"], "fecInicio", array()) || $this->getAttribute($context["atr"], "fecFin", array())) || $this->getAttribute($context["atr"], "duracion", array()))) {
                        // line 337
                        echo "<cac:UsabilityPeriod>
                                ";
                        // line 338
                        if ($this->getAttribute($context["atr"], "fecInicio", array())) {
                            // line 339
                            echo "<cbc:StartDate>";
                            echo twig_date_format_filter($this->env, $this->getAttribute($context["atr"], "fecInicio", array()), "Y-m-d");
                            echo "</cbc:StartDate>
                                ";
                        }
                        // line 341
                        if ($this->getAttribute($context["atr"], "fecFin", array())) {
                            // line 342
                            echo "<cbc:EndDate>";
                            echo twig_date_format_filter($this->env, $this->getAttribute($context["atr"], "fecFin", array()), "Y-m-d");
                            echo "</cbc:EndDate>
                                ";
                        }
                        // line 344
                        if ($this->getAttribute($context["atr"], "duracion", array())) {
                            // line 345
                            echo "<cbc:DurationMeasure unitCode=\"DAY\">";
                            echo $this->getAttribute($context["atr"], "duracion", array());
                            echo "</cbc:DurationMeasure>
                                ";
                        }
                        // line 347
                        echo "</cac:UsabilityPeriod>
                        ";
                    }
                    // line 349
                    echo "</cac:AdditionalItemProperty>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['atr'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 352
            echo "</cac:Item>
        <cac:Price>
            <cbc:PriceAmount currencyID=\"";
            // line 354
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoValorUnitario", array()), 6));
            echo "</cbc:PriceAmount>
        </cac:Price>
    </cac:CreditNoteLine>
    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['detail'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 358
        echo "</CreditNote>";
    }

    public function getTemplateName()
    {
        return "notacr2.1.xml.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  878 => 358,  858 => 354,  854 => 352,  846 => 349,  842 => 347,  836 => 345,  834 => 344,  828 => 342,  826 => 341,  820 => 339,  818 => 338,  815 => 337,  813 => 336,  807 => 334,  805 => 333,  801 => 332,  797 => 331,  794 => 330,  790 => 329,  788 => 328,  782 => 325,  779 => 324,  777 => 323,  771 => 320,  768 => 319,  766 => 318,  760 => 315,  757 => 314,  755 => 313,  751 => 312,  747 => 310,  735 => 301,  728 => 299,  722 => 298,  719 => 297,  717 => 296,  710 => 292,  706 => 291,  702 => 290,  699 => 289,  697 => 288,  693 => 287,  689 => 286,  682 => 284,  676 => 283,  673 => 282,  661 => 273,  657 => 272,  650 => 270,  644 => 269,  641 => 268,  639 => 267,  633 => 266,  629 => 264,  620 => 260,  617 => 259,  615 => 258,  606 => 254,  603 => 253,  601 => 252,  594 => 250,  588 => 249,  584 => 248,  581 => 247,  564 => 246,  556 => 244,  548 => 242,  546 => 241,  542 => 239,  527 => 229,  521 => 228,  518 => 227,  516 => 226,  503 => 216,  497 => 215,  494 => 214,  492 => 213,  479 => 203,  473 => 202,  470 => 201,  468 => 200,  455 => 190,  449 => 189,  446 => 188,  444 => 187,  431 => 177,  425 => 176,  422 => 175,  420 => 174,  405 => 164,  399 => 163,  396 => 162,  394 => 161,  379 => 151,  373 => 150,  370 => 149,  368 => 148,  362 => 147,  357 => 144,  353 => 142,  347 => 140,  345 => 139,  339 => 137,  337 => 136,  334 => 135,  332 => 134,  329 => 133,  322 => 129,  316 => 126,  313 => 125,  307 => 123,  305 => 122,  302 => 121,  300 => 120,  298 => 119,  294 => 118,  286 => 115,  281 => 112,  279 => 111,  275 => 109,  271 => 107,  265 => 105,  263 => 104,  257 => 102,  255 => 101,  252 => 100,  250 => 99,  243 => 95,  237 => 92,  232 => 90,  228 => 89,  223 => 88,  217 => 86,  215 => 85,  211 => 84,  207 => 83,  204 => 82,  202 => 81,  198 => 80,  192 => 77,  186 => 74,  171 => 62,  165 => 59,  158 => 55,  155 => 54,  153 => 53,  143 => 49,  139 => 48,  136 => 47,  132 => 46,  130 => 45,  120 => 41,  116 => 40,  113 => 39,  109 => 38,  107 => 37,  101 => 34,  97 => 33,  93 => 31,  87 => 28,  84 => 27,  82 => 26,  77 => 24,  73 => 23,  69 => 22,  63 => 20,  52 => 18,  48 => 17,  44 => 16,  40 => 15,  34 => 14,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "notacr2.1.xml.twig", "/home2/ecositicom/public_html/sgf_ecositi/admin/class/vendor/greenter/xml/src/Xml/Templates/notacr2.1.xml.twig");
    }
}
