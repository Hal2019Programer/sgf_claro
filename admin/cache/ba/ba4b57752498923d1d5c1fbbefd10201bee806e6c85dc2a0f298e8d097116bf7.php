<?php

/* invoice2.1.xml.twig */
class __TwigTemplate_0b4a218b0bb10f18709c674a9f8b526ab37a51b5a5ebdefa40ea83cffdfb2591 extends Twig_Template
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
    </ext:UBLExtensions>";
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
        echo "</cbc:IssueTime>";
        // line 18
        if ($this->getAttribute(($context["doc"] ?? null), "fecVencimiento", array())) {
            // line 19
            echo "<cbc:DueDate>";
            echo twig_date_format_filter($this->env, $this->getAttribute(($context["doc"] ?? null), "fecVencimiento", array()), "Y-m-d");
            echo "</cbc:DueDate>";
        }
        // line 21
        echo "<cbc:InvoiceTypeCode listID=\"";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoOperacion", array());
        echo "\">";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoDoc", array());
        echo "</cbc:InvoiceTypeCode>";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["doc"] ?? null), "legends", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["leg"]) {
            // line 23
            echo "<cbc:Note languageLocaleID=\"";
            echo $this->getAttribute($context["leg"], "code", array());
            echo "\"><![CDATA[";
            echo $this->getAttribute($context["leg"], "value", array());
            echo "]]></cbc:Note>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['leg'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "<cbc:DocumentCurrencyCode>";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "</cbc:DocumentCurrencyCode>";
        // line 26
        if ($this->getAttribute(($context["doc"] ?? null), "compra", array())) {
            // line 27
            echo "<cac:OrderReference>
        <cbc:ID>";
            // line 28
            echo $this->getAttribute(($context["doc"] ?? null), "compra", array());
            echo "</cbc:ID>
    </cac:OrderReference>";
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
    </cac:DespatchDocumentReference>";
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
    </cac:AdditionalDocumentReference>";
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
    </cac:AdditionalDocumentReference>";
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
        echo "]]></cbc:RegistrationName>";
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
        echo "</cbc:AddressTypeCode>";
        // line 92
        if ($this->getAttribute(($context["addr"] ?? null), "urbanizacion", array())) {
            // line 93
            echo "<cbc:CitySubdivisionName>";
            echo $this->getAttribute(($context["addr"] ?? null), "urbanizacion", array());
            echo "</cbc:CitySubdivisionName>";
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
            </cac:PartyLegalEntity>";
        // line 106
        if (($this->getAttribute(($context["emp"] ?? null), "email", array()) || $this->getAttribute(($context["emp"] ?? null), "telephone", array()))) {
            // line 107
            echo "<cac:Contact>";
            // line 108
            if ($this->getAttribute(($context["emp"] ?? null), "telephone", array())) {
                // line 109
                echo "<cbc:Telephone>";
                echo $this->getAttribute(($context["emp"] ?? null), "telephone", array());
                echo "</cbc:Telephone>";
            }
            // line 111
            if ($this->getAttribute(($context["emp"] ?? null), "email", array())) {
                // line 112
                echo "<cbc:ElectronicMail>";
                echo $this->getAttribute(($context["emp"] ?? null), "email", array());
                echo "</cbc:ElectronicMail>";
            }
            // line 114
            echo "</cac:Contact>";
        }
        // line 116
        echo "</cac:Party>
    </cac:AccountingSupplierParty>";
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
        echo "]]></cbc:RegistrationName>";
        // line 126
        if ($this->getAttribute(($context["client"] ?? null), "address", array())) {
            // line 127
            $context["addr"] = $this->getAttribute(($context["client"] ?? null), "address", array());
            // line 128
            echo "<cac:RegistrationAddress>";
            // line 129
            if ($this->getAttribute(($context["addr"] ?? null), "ubigueo", array())) {
                // line 130
                echo "<cbc:ID>";
                echo $this->getAttribute(($context["addr"] ?? null), "ubigueo", array());
                echo "</cbc:ID>";
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
                </cac:RegistrationAddress>";
        }
        // line 140
        echo "</cac:PartyLegalEntity>";
        // line 141
        if (($this->getAttribute(($context["client"] ?? null), "email", array()) || $this->getAttribute(($context["client"] ?? null), "telephone", array()))) {
            // line 142
            echo "<cac:Contact>";
            // line 143
            if ($this->getAttribute(($context["client"] ?? null), "telephone", array())) {
                // line 144
                echo "<cbc:Telephone>";
                echo $this->getAttribute(($context["client"] ?? null), "telephone", array());
                echo "</cbc:Telephone>";
            }
            // line 146
            if ($this->getAttribute(($context["client"] ?? null), "email", array())) {
                // line 147
                echo "<cbc:ElectronicMail>";
                echo $this->getAttribute(($context["client"] ?? null), "email", array());
                echo "</cbc:ElectronicMail>";
            }
            // line 149
            echo "</cac:Contact>";
        }
        // line 151
        echo "</cac:Party>
    </cac:AccountingCustomerParty>";
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
            echo "]]></cbc:RegistrationName>";
            // line 162
            if ($this->getAttribute(($context["seller"] ?? null), "address", array())) {
                // line 163
                $context["addr"] = $this->getAttribute(($context["seller"] ?? null), "address", array());
                // line 164
                echo "<cac:RegistrationAddress>";
                // line 165
                if ($this->getAttribute(($context["addr"] ?? null), "ubigueo", array())) {
                    // line 166
                    echo "<cbc:ID>";
                    echo $this->getAttribute(($context["addr"] ?? null), "ubigueo", array());
                    echo "</cbc:ID>";
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
                </cac:RegistrationAddress>";
            }
            // line 176
            echo "</cac:PartyLegalEntity>";
            // line 177
            if (($this->getAttribute(($context["seller"] ?? null), "email", array()) || $this->getAttribute(($context["seller"] ?? null), "telephone", array()))) {
                // line 178
                echo "<cac:Contact>";
                // line 179
                if ($this->getAttribute(($context["seller"] ?? null), "telephone", array())) {
                    // line 180
                    echo "<cbc:Telephone>";
                    echo $this->getAttribute(($context["seller"] ?? null), "telephone", array());
                    echo "</cbc:Telephone>";
                }
                // line 182
                if ($this->getAttribute(($context["seller"] ?? null), "email", array())) {
                    // line 183
                    echo "<cbc:ElectronicMail>";
                    echo $this->getAttribute(($context["seller"] ?? null), "email", array());
                    echo "</cbc:ElectronicMail>";
                }
                // line 185
                echo "</cac:Contact>";
            }
            // line 187
            echo "</cac:Party>
    </cac:SellerSupplierParty>";
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
    </cac:PaymentTerms>";
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
    </cac:PaymentTerms>";
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
    </cac:PrepaidPayment>";
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
    </cac:AllowanceCharge>";
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
    </cac:AllowanceCharge>";
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
    </cac:AllowanceCharge>";
        }
        // line 250
        echo "<cac:TaxTotal>
        <cbc:TaxAmount currencyID=\"";
        // line 251
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "totalImpuestos", array())));
        echo "</cbc:TaxAmount>";
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
        </cac:TaxSubtotal>";
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
        </cac:TaxSubtotal>";
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
            </cac:TaxSubtotal>";
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
            </cac:TaxSubtotal>";
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
            </cac:TaxSubtotal>";
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
            </cac:TaxSubtotal>";
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
        </cac:TaxSubtotal>";
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
        echo "</cbc:TaxInclusiveAmount>";
        // line 347
        if ($this->getAttribute(($context["doc"] ?? null), "mtoDescuentos", array())) {
            // line 348
            echo "<cbc:AllowanceTotalAmount currencyID=\"";
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoDescuentos", array())));
            echo "</cbc:AllowanceTotalAmount>";
        }
        // line 350
        if ($this->getAttribute(($context["doc"] ?? null), "sumOtrosCargos", array())) {
            // line 351
            echo "<cbc:ChargeTotalAmount currencyID=\"";
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "sumOtrosCargos", array())));
            echo "</cbc:ChargeTotalAmount>";
        }
        // line 353
        if ($this->getAttribute(($context["doc"] ?? null), "totalAnticipos", array())) {
            // line 354
            echo "<cbc:PrepaidAmount currencyID=\"";
            echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
            echo "\">";
            echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "totalAnticipos", array())));
            echo "</cbc:PrepaidAmount>";
        }
        // line 356
        echo "<cbc:PayableAmount currencyID=\"";
        echo $this->getAttribute(($context["doc"] ?? null), "tipoMoneda", array());
        echo "\">";
        echo call_user_func_array($this->env->getFilter('n_format')->getCallable(), array($this->getAttribute(($context["doc"] ?? null), "mtoImpVenta", array())));
        echo "</cbc:PayableAmount>
    </cac:LegalMonetaryTotal>";
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
        <cac:PricingReference>";
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
            </cac:AlternativeConditionPrice>";
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
            </cac:AlternativeConditionPrice>";
            }
            // line 376
            echo "</cac:PricingReference>";
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
        </cac:AllowanceCharge>";
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
        </cac:AllowanceCharge>";
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
            echo "</cbc:TaxAmount>";
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
            </cac:TaxSubtotal>";
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
            echo "</cbc:TaxExemptionReasonCode>";
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
            </cac:TaxSubtotal>";
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
                </cac:TaxSubtotal>";
            }
            // line 444
            echo "</cac:TaxTotal>
        <cac:Item>
            <cbc:Description><![CDATA[";
            // line 446
            echo $this->getAttribute($context["detail"], "descripcion", array());
            echo "]]></cbc:Description>";
            // line 447
            if ($this->getAttribute($context["detail"], "codProducto", array())) {
                // line 448
                echo "<cac:SellersItemIdentification>
                <cbc:ID>";
                // line 449
                echo $this->getAttribute($context["detail"], "codProducto", array());
                echo "</cbc:ID>
            </cac:SellersItemIdentification>";
            }
            // line 452
            if ($this->getAttribute($context["detail"], "codProdSunat", array())) {
                // line 453
                echo "<cac:CommodityClassification>
                <cbc:ItemClassificationCode>";
                // line 454
                echo $this->getAttribute($context["detail"], "codProdSunat", array());
                echo "</cbc:ItemClassificationCode>
            </cac:CommodityClassification>";
            }
            // line 457
            if ($this->getAttribute($context["detail"], "codProdGS1", array())) {
                // line 458
                echo "<cac:StandardItemIdentification>
                <cbc:ID>";
                // line 459
                echo $this->getAttribute($context["detail"], "codProdGS1", array());
                echo "</cbc:ID>
            </cac:StandardItemIdentification>";
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
                    echo "</cbc:NameCode>";
                    // line 467
                    if ($this->getAttribute($context["atr"], "value", array())) {
                        // line 468
                        echo "<cbc:Value>";
                        echo $this->getAttribute($context["atr"], "value", array());
                        echo "</cbc:Value>";
                    }
                    // line 470
                    if ((($this->getAttribute($context["atr"], "fecInicio", array()) || $this->getAttribute($context["atr"], "fecFin", array())) || $this->getAttribute($context["atr"], "duracion", array()))) {
                        // line 471
                        echo "<cac:UsabilityPeriod>";
                        // line 472
                        if ($this->getAttribute($context["atr"], "fecInicio", array())) {
                            // line 473
                            echo "<cbc:StartDate>";
                            echo twig_date_format_filter($this->env, $this->getAttribute($context["atr"], "fecInicio", array()), "Y-m-d");
                            echo "</cbc:StartDate>";
                        }
                        // line 475
                        if ($this->getAttribute($context["atr"], "fecFin", array())) {
                            // line 476
                            echo "<cbc:EndDate>";
                            echo twig_date_format_filter($this->env, $this->getAttribute($context["atr"], "fecFin", array()), "Y-m-d");
                            echo "</cbc:EndDate>";
                        }
                        // line 478
                        if ($this->getAttribute($context["atr"], "duracion", array())) {
                            // line 479
                            echo "<cbc:DurationMeasure unitCode=\"DAY\">";
                            echo $this->getAttribute($context["atr"], "duracion", array());
                            echo "</cbc:DurationMeasure>";
                        }
                        // line 481
                        echo "</cac:UsabilityPeriod>";
                    }
                    // line 483
                    echo "</cac:AdditionalItemProperty>";
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
    </cac:InvoiceLine>";
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
        return array (  1226 => 492,  1207 => 488,  1203 => 486,  1196 => 483,  1193 => 481,  1188 => 479,  1186 => 478,  1181 => 476,  1179 => 475,  1174 => 473,  1172 => 472,  1170 => 471,  1168 => 470,  1163 => 468,  1161 => 467,  1158 => 466,  1154 => 465,  1151 => 464,  1147 => 463,  1145 => 462,  1140 => 459,  1137 => 458,  1135 => 457,  1130 => 454,  1127 => 453,  1125 => 452,  1120 => 449,  1117 => 448,  1115 => 447,  1112 => 446,  1108 => 444,  1097 => 435,  1090 => 433,  1084 => 432,  1081 => 431,  1079 => 430,  1073 => 426,  1069 => 425,  1065 => 424,  1062 => 423,  1060 => 422,  1057 => 421,  1053 => 420,  1046 => 418,  1040 => 417,  1037 => 416,  1026 => 407,  1022 => 406,  1015 => 404,  1009 => 403,  1006 => 402,  1004 => 401,  999 => 400,  996 => 399,  985 => 395,  979 => 394,  975 => 393,  971 => 392,  967 => 390,  963 => 389,  961 => 388,  950 => 384,  944 => 383,  940 => 382,  936 => 381,  932 => 379,  928 => 378,  926 => 377,  924 => 376,  916 => 372,  913 => 371,  911 => 370,  903 => 366,  900 => 365,  898 => 364,  892 => 362,  886 => 361,  882 => 360,  879 => 359,  862 => 358,  855 => 356,  848 => 354,  846 => 353,  839 => 351,  837 => 350,  830 => 348,  828 => 347,  823 => 346,  817 => 345,  813 => 343,  799 => 333,  793 => 332,  790 => 331,  788 => 330,  776 => 320,  770 => 319,  767 => 318,  765 => 317,  753 => 307,  747 => 306,  744 => 305,  742 => 304,  730 => 294,  724 => 293,  721 => 292,  719 => 291,  707 => 281,  701 => 280,  698 => 279,  696 => 278,  682 => 268,  676 => 267,  673 => 266,  671 => 265,  657 => 255,  651 => 254,  648 => 253,  646 => 252,  641 => 251,  638 => 250,  633 => 247,  629 => 246,  625 => 245,  621 => 244,  617 => 242,  615 => 241,  613 => 240,  602 => 236,  596 => 235,  592 => 234,  588 => 233,  584 => 231,  580 => 230,  578 => 229,  567 => 225,  561 => 224,  557 => 223,  553 => 222,  549 => 220,  545 => 219,  543 => 218,  524 => 214,  520 => 213,  517 => 212,  500 => 211,  498 => 210,  493 => 207,  489 => 205,  487 => 204,  482 => 201,  478 => 200,  474 => 199,  467 => 195,  462 => 193,  459 => 192,  457 => 191,  455 => 190,  451 => 187,  448 => 185,  443 => 183,  441 => 182,  436 => 180,  434 => 179,  432 => 178,  430 => 177,  428 => 176,  422 => 172,  416 => 169,  413 => 168,  408 => 166,  406 => 165,  404 => 164,  402 => 163,  400 => 162,  397 => 161,  389 => 158,  384 => 155,  382 => 154,  380 => 153,  377 => 151,  374 => 149,  369 => 147,  367 => 146,  362 => 144,  360 => 143,  358 => 142,  356 => 141,  354 => 140,  348 => 136,  342 => 133,  339 => 132,  334 => 130,  332 => 129,  330 => 128,  328 => 127,  326 => 126,  323 => 125,  315 => 122,  310 => 119,  308 => 118,  305 => 116,  302 => 114,  297 => 112,  295 => 111,  290 => 109,  288 => 108,  286 => 107,  284 => 106,  278 => 102,  272 => 99,  267 => 97,  263 => 96,  258 => 95,  253 => 93,  251 => 92,  248 => 91,  244 => 90,  241 => 89,  239 => 88,  236 => 87,  230 => 84,  224 => 81,  209 => 69,  203 => 66,  197 => 63,  193 => 62,  190 => 61,  171 => 55,  165 => 52,  161 => 51,  157 => 50,  154 => 49,  137 => 48,  135 => 47,  126 => 43,  122 => 42,  119 => 41,  115 => 40,  113 => 39,  104 => 35,  100 => 34,  97 => 33,  93 => 32,  91 => 31,  86 => 28,  83 => 27,  81 => 26,  77 => 25,  67 => 23,  63 => 22,  57 => 21,  52 => 19,  50 => 18,  47 => 17,  43 => 16,  37 => 15,  33 => 13,  31 => 12,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "invoice2.1.xml.twig", "/home2/ecositicom/public_html/sgf-ecositi/admin/class/vendor/greenter/xml/src/Xml/Templates/invoice2.1.xml.twig");
    }
}
