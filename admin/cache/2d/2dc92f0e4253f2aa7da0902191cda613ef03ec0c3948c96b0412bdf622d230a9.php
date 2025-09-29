<?php

/* invoice2.1.xml.twig */
class __TwigTemplate_5a5b205c234804b23cd59ae4d3287bb365ea974e84ae244023853a81214dc147 extends Twig_Template
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
<Invoice xmlns=\"urn:oasis:names:specification:ubl:schema:xsd:Invoice-2\"
         xmlns:cac=\"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2\"
         xmlns:cbc=\"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2\"
         xmlns:ds=\"http://www.w3.org/2000/09/xmldsig#\"
         xmlns:ext=\"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2\">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    ";
        // line 12
        $context["emp"] = $this->getAttribute(($context["doc"] ?? null), "company", array());
        // line 13
        echo "<cbc:UBLVersionID>2.1</cbc:UBLVersionID>
    <cbc:CustomizationID>2.0</cbc:CustomizationID>
    <cbc:ID>";
        // line 15
        echo $this->getAttribute(($context["doc"] ?? null), "serie", array());
        echo "-";
        echo $this->getAttribute(($context["doc"] ?? null), "correlativo", array());
        echo "</cbc:ID>
    <cbc:IssueDate>";
        // line 16
        echo twig_date_format_filter($this->env, $this->getAttribute(($context["doc"] ?? null), "fechaEmision", array()), "Y-m-d");
        echo "</cbc:IssueDate>
    <cbc:IssueTime>";
        // line 17
        echo twig_date_format_filter($this->env, $this->getAttribute(($context["doc"] ?? null), "fechaEmision", array()), "H:i:s");
        echo "</cbc:IssueTime>
    ";
        // line 18
        if ($this->getAttribute(($context["doc"] ?? null), "fecVencimiento", array())) {
            // line 19
            echo "<cbc:DueDate>";
            echo twig_date_format_filter($this->env, $this->getAttribute(($context["doc"] ?? null), "fecVencimiento", array()), "Y-m-d");
            echo "</cbc:DueDate>
    ";
        }
        // line 21
        echo "<cbc:InvoiceTypeCode listID=\"";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoOperacion", array());
        echo "\">";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoDoc", array());
        echo "</cbc:InvoiceTypeCode>
    ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "legends", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["leg"]) {
            // line 23
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
        // line 25
        echo "<cbc:DocumentCurrencyCode>";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "</cbc:DocumentCurrencyCode>
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
        if ($this->getAttribute(($context["doc"] ?? null), "guias", array())) {
            // line 32
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "guias", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["guia"]) {
                // line 33
                echo "<cac:DespatchDocumentReference>
        <cbc:ID>";
                // line 34
                echo $this->getAttribute($context["guia"], "nroDoc", array());
                echo "</cbc:ID>
        <cbc:DocumentTypeCode>";
                // line 35
                echo $this->getAttribute($context["guia"], "tipoDoc", array());
                echo "</cbc:DocumentTypeCode>
    </cac:DespatchDocumentReference>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['guia'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 39
        if ($this->getAttribute(($context["doc"] ?? null), "relDocs", array())) {
            // line 40
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "relDocs", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["rel"]) {
                // line 41
                echo "<cac:AdditionalDocumentReference>
        <cbc:ID>";
                // line 42
                echo $this->getAttribute($context["rel"], "nroDoc", array());
                echo "</cbc:ID>
        <cbc:DocumentTypeCode>";
                // line 43
                echo $this->getAttribute($context["rel"], "tipoDoc", array());
                echo "</cbc:DocumentTypeCode>
    </cac:AdditionalDocumentReference>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rel'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 47
        if ($this->getAttribute(($context["doc"] ?? null), "anticipos", array())) {
            // line 48
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "anticipos", array()));
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
            foreach ($context['_seq'] as $context["_key"] => $context["ant"]) {
                // line 49
                echo "<cac:AdditionalDocumentReference>
        <cbc:ID>";
                // line 50
                echo $this->getAttribute($context["ant"], "nroDocRel", array());
                echo "</cbc:ID>
        <cbc:DocumentTypeCode>";
                // line 51
                echo $this->getAttribute($context["ant"], "tipoDocRel", array());
                echo "</cbc:DocumentTypeCode>
        <cbc:DocumentStatusCode>";
                // line 52
                echo $this->getAttribute($context["loop"], "index", array());
                echo "</cbc:DocumentStatusCode>
        <cac:IssuerParty>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"6\">";
                // line 55
                echo $this->getAttribute(($context["emp"] ?? null), "ruc", array());
                echo "</cbc:ID>
            </cac:PartyIdentification>
        </cac:IssuerParty>
    </cac:AdditionalDocumentReference>
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ant'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 61
        echo "<cac:Signature>
        <cbc:ID>";
        // line 62
        echo $this->getAttribute(($context["emp"] ?? null), "ruc", array());
        echo "</cbc:ID>
\t\t\t\t<cbc:Note>";
        // line 63
        echo $this->getAttribute(($context["emp"] ?? null), "nombreComercial", array());
        echo "</cbc:Note>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>";
        // line 66
        echo $this->getAttribute(($context["emp"] ?? null), "ruc", array());
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[";
        // line 69
        echo $this->getAttribute(($context["emp"] ?? null), "nombreComercial", array());
        echo "]]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#SIGN</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    <cac:AccountingSupplierParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"6\">";
        // line 81
        echo $this->getAttribute(($context["emp"] ?? null), "ruc", array());
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA[";
        // line 84
        echo $this->getAttribute(($context["emp"] ?? null), "nombreComercial", array());
        echo "]]></cbc:Name>
            </cac:PartyName>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
        // line 87
        echo $this->getAttribute(($context["emp"] ?? null), "razonSocial", array());
        echo "]]></cbc:RegistrationName>
                ";
        // line 88
        $context["addr"] = $this->getAttribute(($context["emp"] ?? null), "address", array());
        // line 89
        echo "<cac:RegistrationAddress>
                    <cbc:ID>";
        // line 90
        echo $this->getAttribute(($context["addr"] ?? null), "ubigueo", array());
        echo "</cbc:ID>
                    <cbc:AddressTypeCode>";
        // line 91
        echo $this->getAttribute(($context["addr"] ?? null), "codLocal", array());
        echo "</cbc:AddressTypeCode>
                    ";
        // line 92
        if ($this->getAttribute(($context["addr"] ?? null), "urbanizacion", array())) {
            // line 93
            echo "<cbc:CitySubdivisionName>";
            echo $this->getAttribute(($context["addr"] ?? null), "urbanizacion", array());
            echo "</cbc:CitySubdivisionName>
                    ";
        }
        // line 95
        echo "<cbc:CityName>";
        echo $this->getAttribute(($context["addr"] ?? null), "provincia", array());
        echo "</cbc:CityName>
                    <cbc:CountrySubentity>";
        // line 96
        echo $this->getAttribute(($context["addr"] ?? null), "departamento", array());
        echo "</cbc:CountrySubentity>
                    <cbc:District>";
        // line 97
        echo $this->getAttribute(($context["addr"] ?? null), "distrito", array());
        echo "</cbc:District>
                    <cac:AddressLine>
                        <cbc:Line><![CDATA[";
        // line 99
        echo $this->getAttribute(($context["addr"] ?? null), "direccion", array());
        echo "]]></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>";
        // line 102
        echo $this->getAttribute(($context["addr"] ?? null), "codigoPais", array());
        echo "</cbc:IdentificationCode>
                    </cac:Country>
                </cac:RegistrationAddress>
            </cac:PartyLegalEntity>
            ";
        // line 106
        if (($this->getAttribute(($context["emp"] ?? null), "email", array()) || $this->getAttribute(($context["emp"] ?? null), "telephone", array()))) {
            // line 107
            echo "<cac:Contact>
                ";
            // line 108
            if ($this->getAttribute(($context["emp"] ?? null), "telephone", array())) {
                // line 109
                echo "<cbc:Telephone>";
                echo $this->getAttribute(($context["emp"] ?? null), "telephone", array());
                echo "</cbc:Telephone>
                ";
            }
            // line 111
            if ($this->getAttribute(($context["emp"] ?? null), "email", array())) {
                // line 112
                echo "<cbc:ElectronicMail>";
                echo $this->getAttribute(($context["emp"] ?? null), "email", array());
                echo "</cbc:ElectronicMail>
                ";
            }
            // line 114
            echo "</cac:Contact>
            ";
        }
        // line 116
        echo "</cac:Party>
    </cac:AccountingSupplierParty>
    ";
        // line 118
        $context["client"] = $this->getAttribute(($context["doc"] ?? null), "client", array());
        // line 119
        echo "<cac:AccountingCustomerParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"";
        // line 122
        echo $this->getAttribute(($context["client"] ?? null), "tipoDoc", array());
        echo "\">";
        echo $this->getAttribute(($context["client"] ?? null), "numDoc", array());
        echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
        // line 125
        echo $this->getAttribute(($context["client"] ?? null), "rznSocial", array());
        echo "]]></cbc:RegistrationName>
                ";
        // line 126
        if ($this->getAttribute(($context["client"] ?? null), "address", array())) {
            // line 127
            $context["addr"] = $this->getAttribute(($context["client"] ?? null), "address", array());
            // line 128
            echo "<cac:RegistrationAddress>
                    ";
            // line 129
            if ($this->getAttribute(($context["addr"] ?? null), "ubigueo", array())) {
                // line 130
                echo "<cbc:ID>";
                echo $this->getAttribute(($context["addr"] ?? null), "ubigueo", array());
                echo "</cbc:ID>
                    ";
            }
            // line 132
            echo "<cac:AddressLine>
                        <cbc:Line><![CDATA[";
            // line 133
            echo $this->getAttribute(($context["addr"] ?? null), "direccion", array());
            echo "]]></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>";
            // line 136
            echo $this->getAttribute(($context["addr"] ?? null), "codigoPais", array());
            echo "</cbc:IdentificationCode>
                    </cac:Country>
                </cac:RegistrationAddress>
                ";
        }
        // line 140
        echo "</cac:PartyLegalEntity>
            ";
        // line 141
        if (($this->getAttribute(($context["client"] ?? null), "email", array()) || $this->getAttribute(($context["client"] ?? null), "telephone", array()))) {
            // line 142
            echo "<cac:Contact>
                ";
            // line 143
            if ($this->getAttribute(($context["client"] ?? null), "telephone", array())) {
                // line 144
                echo "<cbc:Telephone>";
                echo $this->getAttribute(($context["client"] ?? null), "telephone", array());
                echo "</cbc:Telephone>
                ";
            }
            // line 146
            if ($this->getAttribute(($context["client"] ?? null), "email", array())) {
                // line 147
                echo "<cbc:ElectronicMail>";
                echo $this->getAttribute(($context["client"] ?? null), "email", array());
                echo "</cbc:ElectronicMail>
                ";
            }
            // line 149
            echo "</cac:Contact>
            ";
        }
        // line 151
        echo "</cac:Party>
    </cac:AccountingCustomerParty>
    ";
        // line 153
        $context["seller"] = $this->getAttribute(($context["doc"] ?? null), "seller", array());
        // line 154
        if (($context["seller"] ?? null)) {
            // line 155
            echo "<cac:SellerSupplierParty>
        <cac:Party>
            <cac:PartyIdentification>
                <cbc:ID schemeID=\"";
            // line 158
            echo $this->getAttribute(($context["seller"] ?? null), "tipoDoc", array());
            echo "\">";
            echo $this->getAttribute(($context["seller"] ?? null), "numDoc", array());
            echo "</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA[";
            // line 161
            echo $this->getAttribute(($context["seller"] ?? null), "rznSocial", array());
            echo "]]></cbc:RegistrationName>
                ";
            // line 162
            if ($this->getAttribute(($context["seller"] ?? null), "address", array())) {
                // line 163
                $context["addr"] = $this->getAttribute(($context["seller"] ?? null), "address", array());
                // line 164
                echo "<cac:RegistrationAddress>
                    ";
                // line 165
                if ($this->getAttribute(($context["addr"] ?? null), "ubigueo", array())) {
                    // line 166
                    echo "<cbc:ID>";
                    echo $this->getAttribute(($context["addr"] ?? null), "ubigueo", array());
                    echo "</cbc:ID>
                    ";
                }
                // line 168
                echo "<cac:AddressLine>
                        <cbc:Line><![CDATA[";
                // line 169
                echo $this->getAttribute(($context["addr"] ?? null), "direccion", array());
                echo "]]></cbc:Line>
                    </cac:AddressLine>
                    <cac:Country>
                        <cbc:IdentificationCode>";
                // line 172
                echo $this->getAttribute(($context["addr"] ?? null), "codigoPais", array());
                echo "</cbc:IdentificationCode>
                    </cac:Country>
                </cac:RegistrationAddress>
                ";
            }
            // line 176
            echo "</cac:PartyLegalEntity>
            ";
            // line 177
            if (($this->getAttribute(($context["seller"] ?? null), "email", array()) || $this->getAttribute(($context["seller"] ?? null), "telephone", array()))) {
                // line 178
                echo "<cac:Contact>
                ";
                // line 179
                if ($this->getAttribute(($context["seller"] ?? null), "telephone", array())) {
                    // line 180
                    echo "<cbc:Telephone>";
                    echo $this->getAttribute(($context["seller"] ?? null), "telephone", array());
                    echo "</cbc:Telephone>
                ";
                }
                // line 182
                if ($this->getAttribute(($context["seller"] ?? null), "email", array())) {
                    // line 183
                    echo "<cbc:ElectronicMail>";
                    echo $this->getAttribute(($context["seller"] ?? null), "email", array());
                    echo "</cbc:ElectronicMail>
                ";
                }
                // line 185
                echo "</cac:Contact>
            ";
            }
            // line 187
            echo "</cac:Party>
    </cac:SellerSupplierParty>
    ";
        }
        // line 190
        if ($this->getAttribute(($context["doc"] ?? null), "detraccion", array())) {
            // line 191
            $context["detr"] = $this->getAttribute(($context["doc"] ?? null), "detraccion", array());
            // line 192
            echo "<cac:PaymentMeans>
        <cbc:PaymentMeansCode>";
            // line 193
            echo $this->getAttribute(($context["detr"] ?? null), "codMedioPago", array());
            echo "</cbc:PaymentMeansCode>
        <cac:PayeeFinancialAccount>
            <cbc:ID>";
            // line 195
            echo $this->getAttribute(($context["detr"] ?? null), "ctaBanco", array());
            echo "</cbc:ID>
        </cac:PayeeFinancialAccount>
    </cac:PaymentMeans>
    <cac:PaymentTerms>
        <cbc:PaymentMeansID>";
            // line 199
            echo $this->getAttribute(($context["detr"] ?? null), "codBienDetraccion", array());
            echo "</cbc:PaymentMeansID>
        <cbc:PaymentPercent>";
            // line 200
            echo $this->getAttribute(($context["detr"] ?? null), "percent", array());
            echo "</cbc:PaymentPercent>
        <cbc:Amount currencyID=\"PEN\">";
            // line 201
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["detr"] ?? null), "mount", array())));
            echo "</cbc:Amount>
    </cac:PaymentTerms>
    ";
        }
        // line 204
        if ($this->getAttribute(($context["doc"] ?? null), "perception", array())) {
            // line 205
            echo "<cac:PaymentTerms>
        <cbc:ID>Percepcion</cbc:ID>
        <cbc:Amount currencyID=\"PEN\">";
            // line 207
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($this->getAttribute(($context["doc"] ?? null), "perception", array()), "mtoTotal", array())));
            echo "</cbc:Amount>
    </cac:PaymentTerms>
    ";
        }
        // line 210
        if ($this->getAttribute(($context["doc"] ?? null), "anticipos", array())) {
            // line 211
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "anticipos", array()));
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
            foreach ($context['_seq'] as $context["_key"] => $context["ant"]) {
                // line 212
                echo "<cac:PrepaidPayment>
        <cbc:ID>";
                // line 213
                echo $this->getAttribute($context["loop"], "index", array());
                echo "</cbc:ID>
        <cbc:PaidAmount currencyID=\"";
                // line 214
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["ant"], "total", array())));
                echo "</cbc:PaidAmount>
    </cac:PrepaidPayment>
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ant'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 218
        if ($this->getAttribute(($context["doc"] ?? null), "cargos", array())) {
            // line 219
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "cargos", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["cargo"]) {
                // line 220
                echo "<cac:AllowanceCharge>
        <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReasonCode>";
                // line 222
                echo $this->getAttribute($context["cargo"], "codTipo", array());
                echo "</cbc:AllowanceChargeReasonCode>
        <cbc:MultiplierFactorNumeric>";
                // line 223
                echo $this->getAttribute($context["cargo"], "factor", array());
                echo "</cbc:MultiplierFactorNumeric>
        <cbc:Amount currencyID=\"";
                // line 224
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["cargo"], "monto", array())));
                echo "</cbc:Amount>
        <cbc:BaseAmount currencyID=\"";
                // line 225
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["cargo"], "montoBase", array())));
                echo "</cbc:BaseAmount>
    </cac:AllowanceCharge>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cargo'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 229
        if ($this->getAttribute(($context["doc"] ?? null), "descuentos", array())) {
            // line 230
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "descuentos", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["desc"]) {
                // line 231
                echo "<cac:AllowanceCharge>
        <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReasonCode>";
                // line 233
                echo $this->getAttribute($context["desc"], "codTipo", array());
                echo "</cbc:AllowanceChargeReasonCode>
        <cbc:MultiplierFactorNumeric>";
                // line 234
                echo $this->getAttribute($context["desc"], "factor", array());
                echo "</cbc:MultiplierFactorNumeric>
        <cbc:Amount currencyID=\"";
                // line 235
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["desc"], "monto", array())));
                echo "</cbc:Amount>
        <cbc:BaseAmount currencyID=\"";
                // line 236
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["desc"], "montoBase", array())));
                echo "</cbc:BaseAmount>
    </cac:AllowanceCharge>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['desc'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 240
        if ($this->getAttribute(($context["doc"] ?? null), "perception", array())) {
            // line 241
            $context["perc"] = $this->getAttribute(($context["doc"] ?? null), "perception", array());
            // line 242
            echo "<cac:AllowanceCharge>
        <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReasonCode>";
            // line 244
            echo $this->getAttribute(($context["perc"] ?? null), "codReg", array());
            echo "</cbc:AllowanceChargeReasonCode>
        <cbc:MultiplierFactorNumeric>";
            // line 245
            echo $this->getAttribute(($context["perc"] ?? null), "porcentaje", array());
            echo "</cbc:MultiplierFactorNumeric>
        <cbc:Amount currencyID=\"PEN\">";
            // line 246
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["perc"] ?? null), "mto", array())));
            echo "</cbc:Amount>
        <cbc:BaseAmount currencyID=\"PEN\">";
            // line 247
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["perc"] ?? null), "mtoBase", array())));
            echo "</cbc:BaseAmount>
    </cac:AllowanceCharge>
    ";
        }
        // line 250
        echo "<cac:TaxTotal>
        <cbc:TaxAmount currencyID=\"";
        // line 251
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "totalImpuestos", array())));
        echo "</cbc:TaxAmount>
        ";
        // line 252
        if ($this->getAttribute(($context["doc"] ?? null), "mtoISC", array())) {
            // line 253
            echo "<cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID=\"";
            // line 254
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoBaseIsc", array())));
            echo "</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID=\"";
            // line 255
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
        // line 265
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperGravadas", array())) {
            // line 266
            echo "<cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID=\"";
            // line 267
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperGravadas", array())));
            echo "</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID=\"";
            // line 268
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
        // line 278
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperInafectas", array())) {
            // line 279
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 280
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperInafectas", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 281
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
        // line 291
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperExoneradas", array())) {
            // line 292
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 293
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperExoneradas", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 294
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
        // line 304
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperGratuitas", array())) {
            // line 305
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 306
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperGratuitas", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 307
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
        // line 317
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOperExportacion", array())) {
            // line 318
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 319
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoOperExportacion", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 320
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
        // line 330
        if ($this->getAttribute(($context["doc"] ?? null), "mtoOtrosTributos", array())) {
            // line 331
            echo "<cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID=\"";
            // line 332
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoBaseOth", array())));
            echo "</cbc:TaxableAmount>
            <cbc:TaxAmount currencyID=\"";
            // line 333
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
        // line 343
        echo "</cac:TaxTotal>
    <cac:LegalMonetaryTotal>
        <cbc:LineExtensionAmount currencyID=\"";
        // line 345
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "valorVenta", array())));
        echo "</cbc:LineExtensionAmount>
        <cbc:TaxInclusiveAmount currencyID=\"";
        // line 346
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoImpVenta", array())));
        echo "</cbc:TaxInclusiveAmount>
        ";
        // line 347
        if ($this->getAttribute(($context["doc"] ?? null), "mtoDescuentos", array())) {
            // line 348
            echo "<cbc:AllowanceTotalAmount currencyID=\"";
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoDescuentos", array())));
            echo "</cbc:AllowanceTotalAmount>
        ";
        }
        // line 350
        if ($this->getAttribute(($context["doc"] ?? null), "sumOtrosCargos", array())) {
            // line 351
            echo "<cbc:ChargeTotalAmount currencyID=\"";
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "sumOtrosCargos", array())));
            echo "</cbc:ChargeTotalAmount>
        ";
        }
        // line 353
        if ($this->getAttribute(($context["doc"] ?? null), "totalAnticipos", array())) {
            // line 354
            echo "<cbc:PrepaidAmount currencyID=\"";
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "totalAnticipos", array())));
            echo "</cbc:PrepaidAmount>
        ";
        }
        // line 356
        echo "<cbc:PayableAmount currencyID=\"";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoImpVenta", array())));
        echo "</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>
    ";
        // line 358
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
            // line 359
            echo "<cac:InvoiceLine>
        <cbc:ID>";
            // line 360
            echo $this->getAttribute($context["loop"], "index", array());
            echo "</cbc:ID>
        <cbc:InvoicedQuantity unitCode=\"";
            // line 361
            echo $this->getAttribute($context["detail"], "unidad", array());
            echo "\">";
            echo $this->getAttribute($context["detail"], "cantidad", array());
            echo "</cbc:InvoicedQuantity>
        <cbc:LineExtensionAmount currencyID=\"";
            // line 362
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoValorVenta", array())));
            echo "</cbc:LineExtensionAmount>
        <cac:PricingReference>
            ";
            // line 364
            if ($this->getAttribute($context["detail"], "mtoPrecioUnitario", array())) {
                // line 365
                echo "<cac:AlternativeConditionPrice>
                <cbc:PriceAmount currencyID=\"";
                // line 366
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoPrecioUnitario", array()), 6));
                echo "</cbc:PriceAmount>
                <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
            </cac:AlternativeConditionPrice>
            ";
            }
            // line 370
            if ($this->getAttribute($context["detail"], "mtoValorGratuito", array())) {
                // line 371
                echo "<cac:AlternativeConditionPrice>
                <cbc:PriceAmount currencyID=\"";
                // line 372
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoValorGratuito", array()), 6));
                echo "</cbc:PriceAmount>
                <cbc:PriceTypeCode>02</cbc:PriceTypeCode>
            </cac:AlternativeConditionPrice>
            ";
            }
            // line 376
            echo "</cac:PricingReference>
        ";
            // line 377
            if ($this->getAttribute($context["detail"], "cargos", array())) {
                // line 378
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["detail"], "cargos", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["cargo"]) {
                    // line 379
                    echo "<cac:AllowanceCharge>
            <cbc:ChargeIndicator>true</cbc:ChargeIndicator>
            <cbc:AllowanceChargeReasonCode>";
                    // line 381
                    echo $this->getAttribute($context["cargo"], "codTipo", array());
                    echo "</cbc:AllowanceChargeReasonCode>
            <cbc:MultiplierFactorNumeric>";
                    // line 382
                    echo $this->getAttribute($context["cargo"], "factor", array());
                    echo "</cbc:MultiplierFactorNumeric>
            <cbc:Amount currencyID=\"";
                    // line 383
                    echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                    echo "\">";
                    echo $this->getAttribute($context["cargo"], "monto", array());
                    echo "</cbc:Amount>
            <cbc:BaseAmount currencyID=\"";
                    // line 384
                    echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                    echo "\">";
                    echo $this->getAttribute($context["cargo"], "montoBase", array());
                    echo "</cbc:BaseAmount>
        </cac:AllowanceCharge>
        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cargo'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 388
            if ($this->getAttribute($context["detail"], "descuentos", array())) {
                // line 389
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["detail"], "descuentos", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["desc"]) {
                    // line 390
                    echo "<cac:AllowanceCharge>
            <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
            <cbc:AllowanceChargeReasonCode>";
                    // line 392
                    echo $this->getAttribute($context["desc"], "codTipo", array());
                    echo "</cbc:AllowanceChargeReasonCode>
            <cbc:MultiplierFactorNumeric>";
                    // line 393
                    echo $this->getAttribute($context["desc"], "factor", array());
                    echo "</cbc:MultiplierFactorNumeric>
            <cbc:Amount currencyID=\"";
                    // line 394
                    echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                    echo "\">";
                    echo $this->getAttribute($context["desc"], "monto", array());
                    echo "</cbc:Amount>
            <cbc:BaseAmount currencyID=\"";
                    // line 395
                    echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                    echo "\">";
                    echo $this->getAttribute($context["desc"], "montoBase", array());
                    echo "</cbc:BaseAmount>
        </cac:AllowanceCharge>
        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['desc'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 399
            echo "<cac:TaxTotal>
            <cbc:TaxAmount currencyID=\"";
            // line 400
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "totalImpuestos", array())));
            echo "</cbc:TaxAmount>
            ";
            // line 401
            if ($this->getAttribute($context["detail"], "isc", array())) {
                // line 402
                echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
                // line 403
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoBaseIsc", array())));
                echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
                // line 404
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "isc", array())));
                echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
                // line 406
                echo $this->getAttribute($context["detail"], "porcentajeIsc", array());
                echo "</cbc:Percent>
                    <cbc:TierRange>";
                // line 407
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
            // line 416
            echo "<cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID=\"";
            // line 417
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoBaseIgv", array())));
            echo "</cbc:TaxableAmount>
                <cbc:TaxAmount currencyID=\"";
            // line 418
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "igv", array())));
            echo "</cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:Percent>";
            // line 420
            echo $this->getAttribute($context["detail"], "porcentajeIgv", array());
            echo "</cbc:Percent>
                    <cbc:TaxExemptionReasonCode>";
            // line 421
            echo $this->getAttribute($context["detail"], "tipAfeIgv", array());
            echo "</cbc:TaxExemptionReasonCode>
                    ";
            // line 422
            $context["afect"] = Greenter\Xml\Filter\TributoFunction::getByAfectacion($this->getAttribute($context["detail"], "tipAfeIgv", array()));
            // line 423
            echo "<cac:TaxScheme>
                        <cbc:ID>";
            // line 424
            echo $this->getAttribute(($context["afect"] ?? null), "id", array());
            echo "</cbc:ID>
                        <cbc:Name>";
            // line 425
            echo $this->getAttribute(($context["afect"] ?? null), "name", array());
            echo "</cbc:Name>
                        <cbc:TaxTypeCode>";
            // line 426
            echo $this->getAttribute(($context["afect"] ?? null), "code", array());
            echo "</cbc:TaxTypeCode>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
            ";
            // line 430
            if ($this->getAttribute($context["detail"], "otroTributo", array())) {
                // line 431
                echo "<cac:TaxSubtotal>
                    <cbc:TaxableAmount currencyID=\"";
                // line 432
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoBaseOth", array())));
                echo "</cbc:TaxableAmount>
                    <cbc:TaxAmount currencyID=\"";
                // line 433
                echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
                echo "\">";
                echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "otroTributo", array())));
                echo "</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cbc:Percent>";
                // line 435
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
            // line 444
            echo "</cac:TaxTotal>
        <cac:Item>
            <cbc:Description><![CDATA[";
            // line 446
            echo $this->getAttribute($context["detail"], "descripcion", array());
            echo "]]></cbc:Description>
            ";
            // line 447
            if ($this->getAttribute($context["detail"], "codProducto", array())) {
                // line 448
                echo "<cac:SellersItemIdentification>
                <cbc:ID>";
                // line 449
                echo $this->getAttribute($context["detail"], "codProducto", array());
                echo "</cbc:ID>
            </cac:SellersItemIdentification>
            ";
            }
            // line 452
            if ($this->getAttribute($context["detail"], "codProdSunat", array())) {
                // line 453
                echo "<cac:CommodityClassification>
                <cbc:ItemClassificationCode>";
                // line 454
                echo $this->getAttribute($context["detail"], "codProdSunat", array());
                echo "</cbc:ItemClassificationCode>
            </cac:CommodityClassification>
            ";
            }
            // line 457
            if ($this->getAttribute($context["detail"], "codProdGS1", array())) {
                // line 458
                echo "<cac:StandardItemIdentification>
                <cbc:ID>";
                // line 459
                echo $this->getAttribute($context["detail"], "codProdGS1", array());
                echo "</cbc:ID>
            </cac:StandardItemIdentification>
            ";
            }
            // line 462
            if ($this->getAttribute($context["detail"], "atributos", array())) {
                // line 463
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["detail"], "atributos", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["atr"]) {
                    // line 464
                    echo "<cac:AdditionalItemProperty >
                        <cbc:Name>";
                    // line 465
                    echo $this->getAttribute($context["atr"], "name", array());
                    echo "</cbc:Name>
                        <cbc:NameCode>";
                    // line 466
                    echo $this->getAttribute($context["atr"], "code", array());
                    echo "</cbc:NameCode>
                        ";
                    // line 467
                    if ($this->getAttribute($context["atr"], "value", array())) {
                        // line 468
                        echo "<cbc:Value>";
                        echo $this->getAttribute($context["atr"], "value", array());
                        echo "</cbc:Value>
                        ";
                    }
                    // line 470
                    if ((($this->getAttribute($context["atr"], "fecInicio", array()) || $this->getAttribute($context["atr"], "fecFin", array())) || $this->getAttribute($context["atr"], "duracion", array()))) {
                        // line 471
                        echo "<cac:UsabilityPeriod>
                                ";
                        // line 472
                        if ($this->getAttribute($context["atr"], "fecInicio", array())) {
                            // line 473
                            echo "<cbc:StartDate>";
                            echo twig_date_format_filter($this->env, $this->getAttribute($context["atr"], "fecInicio", array()), "Y-m-d");
                            echo "</cbc:StartDate>
                                ";
                        }
                        // line 475
                        if ($this->getAttribute($context["atr"], "fecFin", array())) {
                            // line 476
                            echo "<cbc:EndDate>";
                            echo twig_date_format_filter($this->env, $this->getAttribute($context["atr"], "fecFin", array()), "Y-m-d");
                            echo "</cbc:EndDate>
                                ";
                        }
                        // line 478
                        if ($this->getAttribute($context["atr"], "duracion", array())) {
                            // line 479
                            echo "<cbc:DurationMeasure unitCode=\"DAY\">";
                            echo $this->getAttribute($context["atr"], "duracion", array());
                            echo "</cbc:DurationMeasure>
                                ";
                        }
                        // line 481
                        echo "</cac:UsabilityPeriod>
                        ";
                    }
                    // line 483
                    echo "</cac:AdditionalItemProperty>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['atr'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 486
            echo "</cac:Item>
        <cac:Price>
            <cbc:PriceAmount currencyID=\"";
            // line 488
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute($context["detail"], "mtoValorUnitario", array()), 6));
            echo "</cbc:PriceAmount>
        </cac:Price>
    </cac:InvoiceLine>
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
        // line 492
        echo "</Invoice>
";
    }

    public function getTemplateName()
    {
        return "invoice2.1.xml.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1308 => 492,  1288 => 488,  1284 => 486,  1276 => 483,  1272 => 481,  1266 => 479,  1264 => 478,  1258 => 476,  1256 => 475,  1250 => 473,  1248 => 472,  1245 => 471,  1243 => 470,  1237 => 468,  1235 => 467,  1231 => 466,  1227 => 465,  1224 => 464,  1220 => 463,  1218 => 462,  1212 => 459,  1209 => 458,  1207 => 457,  1201 => 454,  1198 => 453,  1196 => 452,  1190 => 449,  1187 => 448,  1185 => 447,  1181 => 446,  1177 => 444,  1165 => 435,  1158 => 433,  1152 => 432,  1149 => 431,  1147 => 430,  1140 => 426,  1136 => 425,  1132 => 424,  1129 => 423,  1127 => 422,  1123 => 421,  1119 => 420,  1112 => 418,  1106 => 417,  1103 => 416,  1091 => 407,  1087 => 406,  1080 => 404,  1074 => 403,  1071 => 402,  1069 => 401,  1063 => 400,  1060 => 399,  1048 => 395,  1042 => 394,  1038 => 393,  1034 => 392,  1030 => 390,  1026 => 389,  1024 => 388,  1012 => 384,  1006 => 383,  1002 => 382,  998 => 381,  994 => 379,  990 => 378,  988 => 377,  985 => 376,  976 => 372,  973 => 371,  971 => 370,  962 => 366,  959 => 365,  957 => 364,  950 => 362,  944 => 361,  940 => 360,  937 => 359,  920 => 358,  912 => 356,  904 => 354,  902 => 353,  894 => 351,  892 => 350,  884 => 348,  882 => 347,  876 => 346,  870 => 345,  866 => 343,  851 => 333,  845 => 332,  842 => 331,  840 => 330,  827 => 320,  821 => 319,  818 => 318,  816 => 317,  803 => 307,  797 => 306,  794 => 305,  792 => 304,  779 => 294,  773 => 293,  770 => 292,  768 => 291,  755 => 281,  749 => 280,  746 => 279,  744 => 278,  729 => 268,  723 => 267,  720 => 266,  718 => 265,  703 => 255,  697 => 254,  694 => 253,  692 => 252,  686 => 251,  683 => 250,  677 => 247,  673 => 246,  669 => 245,  665 => 244,  661 => 242,  659 => 241,  657 => 240,  645 => 236,  639 => 235,  635 => 234,  631 => 233,  627 => 231,  623 => 230,  621 => 229,  609 => 225,  603 => 224,  599 => 223,  595 => 222,  591 => 220,  587 => 219,  585 => 218,  565 => 214,  561 => 213,  558 => 212,  541 => 211,  539 => 210,  533 => 207,  529 => 205,  527 => 204,  521 => 201,  517 => 200,  513 => 199,  506 => 195,  501 => 193,  498 => 192,  496 => 191,  494 => 190,  489 => 187,  485 => 185,  479 => 183,  477 => 182,  471 => 180,  469 => 179,  466 => 178,  464 => 177,  461 => 176,  454 => 172,  448 => 169,  445 => 168,  439 => 166,  437 => 165,  434 => 164,  432 => 163,  430 => 162,  426 => 161,  418 => 158,  413 => 155,  411 => 154,  409 => 153,  405 => 151,  401 => 149,  395 => 147,  393 => 146,  387 => 144,  385 => 143,  382 => 142,  380 => 141,  377 => 140,  370 => 136,  364 => 133,  361 => 132,  355 => 130,  353 => 129,  350 => 128,  348 => 127,  346 => 126,  342 => 125,  334 => 122,  329 => 119,  327 => 118,  323 => 116,  319 => 114,  313 => 112,  311 => 111,  305 => 109,  303 => 108,  300 => 107,  298 => 106,  291 => 102,  285 => 99,  280 => 97,  276 => 96,  271 => 95,  265 => 93,  263 => 92,  259 => 91,  255 => 90,  252 => 89,  250 => 88,  246 => 87,  240 => 84,  234 => 81,  219 => 69,  213 => 66,  207 => 63,  203 => 62,  200 => 61,  180 => 55,  174 => 52,  170 => 51,  166 => 50,  163 => 49,  146 => 48,  144 => 47,  134 => 43,  130 => 42,  127 => 41,  123 => 40,  121 => 39,  111 => 35,  107 => 34,  104 => 33,  100 => 32,  98 => 31,  92 => 28,  89 => 27,  87 => 26,  82 => 25,  71 => 23,  67 => 22,  60 => 21,  54 => 19,  52 => 18,  48 => 17,  44 => 16,  38 => 15,  34 => 13,  32 => 12,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "invoice2.1.xml.twig", "/home2/ecositicom/public_html/sgf_ecositi/admin/class/vendor/greenter/xml/src/Xml/Templates/invoice2.1.xml.twig");
    }
}
