<?php

namespace Cruk\EventSdk;

class Address extends EWSObject
{
    public static $countries = [
        "AF" => ['alpha2' => 'AF', 'alpha3' => 'AFG', "name" => "Afghanistan",],
        "AX" => ['alpha2' => 'AX', 'alpha3' => 'ALA', "name" => "Åland Islands",],
        "AL" => ['alpha2' => 'AL', 'alpha3' => 'ALB', "name" => "Albania",],
        "DZ" => ['alpha2' => 'DZ', 'alpha3' => 'DZA', "name" => "Algeria",],
        "AS" => ['alpha2' => 'AS', 'alpha3' => 'ASM', "name" => "American Samoa",],
        "AD" => ['alpha2' => 'AD', 'alpha3' => 'AND', "name" => "Andorra",],
        "AO" => ['alpha2' => 'AO', 'alpha3' => 'AGO', "name" => "Angola",],
        "AI" => ['alpha2' => 'AI', 'alpha3' => 'AIA', "name" => "Anguilla",],
        "AQ" => ['alpha2' => 'AQ', 'alpha3' => 'ATA', "name" => "Antarctica",],
        "AG" => ['alpha2' => 'AG', 'alpha3' => 'ATG', "name" => "Antigua and Barbuda",],
        "AR" => ['alpha2' => 'AR', 'alpha3' => 'ARG', "name" => "Argentina",],
        "AM" => ['alpha2' => 'AM', 'alpha3' => 'ARM', "name" => "Armenia",],
        "AW" => ['alpha2' => 'AW', 'alpha3' => 'ABW', "name" => "Aruba",],
        "AU" => ['alpha2' => 'AU', 'alpha3' => 'AUS', "name" => "Australia",],
        "AT" => ['alpha2' => 'AT', 'alpha3' => 'AUT', "name" => "Austria",],
        "AZ" => ['alpha2' => 'AZ', 'alpha3' => 'AZE', "name" => "Azerbaijan",],
        "BS" => ['alpha2' => 'BS', 'alpha3' => 'BHS', "name" => "Bahamas",],
        "BH" => ['alpha2' => 'BH', 'alpha3' => 'BHR', "name" => "Bahrain",],
        "BD" => ['alpha2' => 'BD', 'alpha3' => 'BGD', "name" => "Bangladesh",],
        "BB" => ['alpha2' => 'BB', 'alpha3' => 'BRB', "name" => "Barbados",],
        "BY" => ['alpha2' => 'BY', 'alpha3' => 'BLR', "name" => "Belarus",],
        "BE" => ['alpha2' => 'BE', 'alpha3' => 'BEL', "name" => "Belgium",],
        "BZ" => ['alpha2' => 'BZ', 'alpha3' => 'BLZ', "name" => "Belize",],
        "BJ" => ['alpha2' => 'BJ', 'alpha3' => 'BEN', "name" => "Benin",],
        "BM" => ['alpha2' => 'BM', 'alpha3' => 'BMU', "name" => "Bermuda",],
        "BT" => ['alpha2' => 'BT', 'alpha3' => 'BTN', "name" => "Bhutan",],
        "BO" => ['alpha2' => 'BO', 'alpha3' => 'BOL', "name" => "Bolivia",],
        "BA" => ['alpha2' => 'BA', 'alpha3' => 'BIH', "name" => "Bosnia and Herzegovina",],
        "BW" => ['alpha2' => 'BW', 'alpha3' => 'BWA', "name" => "Botswana",],
        "BV" => ['alpha2' => 'BV', 'alpha3' => 'BVT', "name" => "Bouvet Island",],
        "BR" => ['alpha2' => 'BR', 'alpha3' => 'BRA', "name" => "Brazil",],
        "IO" => ['alpha2' => 'IO', 'alpha3' => 'IOT', "name" => "British Indian Ocean Territory",],
        "BN" => ['alpha2' => 'BN', 'alpha3' => 'BRN', "name" => "Brunei Darussalam",],
        "BG" => ['alpha2' => 'BG', 'alpha3' => 'BGR', "name" => "Bulgaria",],
        "BF" => ['alpha2' => 'BF', 'alpha3' => 'BFA', "name" => "Burkina Faso",],
        "BI" => ['alpha2' => 'BI', 'alpha3' => 'BDI', "name" => "Burundi",],
        "KH" => ['alpha2' => 'KH', 'alpha3' => 'KHM', "name" => "Cambodia",],
        "CM" => ['alpha2' => 'CM', 'alpha3' => 'CMR', "name" => "Cameroon",],
        "CA" => ['alpha2' => 'CA', 'alpha3' => 'CAN', "name" => "Canada",],
        "CV" => ['alpha2' => 'CV', 'alpha3' => 'CPV', "name" => "Cape Verde",],
        "KY" => ['alpha2' => 'KY', 'alpha3' => 'CYM', "name" => "Cayman Islands",],
        "CF" => ['alpha2' => 'CF', 'alpha3' => 'CAF', "name" => "Central African Republic",],
        "TD" => ['alpha2' => 'TD', 'alpha3' => 'TCD', "name" => "Chad",],
        "CL" => ['alpha2' => 'CL', 'alpha3' => 'CHL', "name" => "Chile",],
        "CN" => ['alpha2' => 'CN', 'alpha3' => 'CHN', "name" => "China",],
        "CX" => ['alpha2' => 'CX', 'alpha3' => 'CXR', "name" => "Christmas Island",],
        "CC" => ['alpha2' => 'CC', 'alpha3' => 'CCK', "name" => "Cocos (Keeling) Islands",],
        "CO" => ['alpha2' => 'CO', 'alpha3' => 'COL', "name" => "Colombia",],
        "KM" => ['alpha2' => 'KM', 'alpha3' => 'COM', "name" => "Comoros",],
        "CG" => ['alpha2' => 'CG', 'alpha3' => 'COG', "name" => "Congo",],
        "CD" => ['alpha2' => 'CD', 'alpha3' => 'COD', "name" => "The Democratic Republic of The Congo",],
        "CK" => ['alpha2' => 'CK', 'alpha3' => 'COK', "name" => "Cook Islands",],
        "CR" => ['alpha2' => 'CR', 'alpha3' => 'CRI', "name" => "Costa Rica",],
        "CI" => ['alpha2' => 'CI', 'alpha3' => 'CIV', "name" => "Cote D'ivoire",],
        "HR" => ['alpha2' => 'HR', 'alpha3' => 'HRV', "name" => "Croatia",],
        "CU" => ['alpha2' => 'CU', 'alpha3' => 'CUB', "name" => "Cuba",],
        "CY" => ['alpha2' => 'CY', 'alpha3' => 'CYP', "name" => "Cyprus",],
        "CZ" => ['alpha2' => 'CZ', 'alpha3' => 'CZE', "name" => "Czech Republic",],
        "DK" => ['alpha2' => 'DK', 'alpha3' => 'DNK', "name" => "Denmark",],
        "DJ" => ['alpha2' => 'DJ', 'alpha3' => 'DJI', "name" => "Djibouti",],
        "DM" => ['alpha2' => 'DM', 'alpha3' => 'DMA', "name" => "Dominica",],
        "DO" => ['alpha2' => 'DO', 'alpha3' => 'DOM', "name" => "Dominican Republic",],
        "EC" => ['alpha2' => 'EC', 'alpha3' => 'ECU', "name" => "Ecuador",],
        "EG" => ['alpha2' => 'EG', 'alpha3' => 'EGY', "name" => "Egypt",],
        "SV" => ['alpha2' => 'SV', 'alpha3' => 'SLV', "name" => "El Salvador",],
        "GQ" => ['alpha2' => 'GQ', 'alpha3' => 'GNQ', "name" => "Equatorial Guinea",],
        "ER" => ['alpha2' => 'ER', 'alpha3' => 'ERI', "name" => "Eritrea",],
        "EE" => ['alpha2' => 'EE', 'alpha3' => 'EST', "name" => "Estonia",],
        "ET" => ['alpha2' => 'ET', 'alpha3' => 'ETH', "name" => "Ethiopia",],
        "FK" => ['alpha2' => 'FK', 'alpha3' => 'FLK', "name" => "Falkland Islands (Malvinas)",],
        "FO" => ['alpha2' => 'FO', 'alpha3' => 'FRO', "name" => "Faroe Islands",],
        "FJ" => ['alpha2' => 'FJ', 'alpha3' => 'FJI', "name" => "Fiji",],
        "FI" => ['alpha2' => 'FI', 'alpha3' => 'FIN', "name" => "Finland",],
        "FR" => ['alpha2' => 'FR', 'alpha3' => 'FRA', "name" => "France",],
        "GF" => ['alpha2' => 'GF', 'alpha3' => 'GUF', "name" => "French Guiana",],
        "PF" => ['alpha2' => 'PF', 'alpha3' => 'PYF', "name" => "French Polynesia",],
        "TF" => ['alpha2' => 'TF', 'alpha3' => 'ATF', "name" => "French Southern Territories",],
        "GA" => ['alpha2' => 'GA', 'alpha3' => 'GAB', "name" => "Gabon",],
        "GM" => ['alpha2' => 'GM', 'alpha3' => 'GMB', "name" => "Gambia",],
        "GE" => ['alpha2' => 'GE', 'alpha3' => 'GEO', "name" => "Georgia",],
        "DE" => ['alpha2' => 'DE', 'alpha3' => 'DEU', "name" => "Germany",],
        "GH" => ['alpha2' => 'GH', 'alpha3' => 'GHA', "name" => "Ghana",],
        "GI" => ['alpha2' => 'GI', 'alpha3' => 'GIB', "name" => "Gibraltar",],
        "GR" => ['alpha2' => 'GR', 'alpha3' => 'GRC', "name" => "Greece",],
        "GL" => ['alpha2' => 'GL', 'alpha3' => 'GRL', "name" => "Greenland",],
        "GD" => ['alpha2' => 'GD', 'alpha3' => 'GRD', "name" => "Grenada",],
        "GP" => ['alpha2' => 'GP', 'alpha3' => 'GLP', "name" => "Guadeloupe",],
        "GU" => ['alpha2' => 'GU', 'alpha3' => 'GUM', "name" => "Guam",],
        "GT" => ['alpha2' => 'GT', 'alpha3' => 'GTM', "name" => "Guatemala",],
        "GG" => ['alpha2' => 'GG', 'alpha3' => 'GGY', "name" => "Guernsey",],
        "GN" => ['alpha2' => 'GN', 'alpha3' => 'GIN', "name" => "Guinea",],
        "GW" => ['alpha2' => 'GW', 'alpha3' => 'GNB', "name" => "Guinea-bissau",],
        "GY" => ['alpha2' => 'GY', 'alpha3' => 'GUY', "name" => "Guyana",],
        "HT" => ['alpha2' => 'HT', 'alpha3' => 'HTI', "name" => "Haiti",],
        "HM" => ['alpha2' => 'HM', 'alpha3' => 'HMD', "name" => "Heard Island and Mcdonald Islands",],
        "VA" => ['alpha2' => 'VA', 'alpha3' => 'VAT', "name" => "Holy See (Vatican City State)",],
        "HN" => ['alpha2' => 'HN', 'alpha3' => 'HND', "name" => "Honduras",],
        "HK" => ['alpha2' => 'HK', 'alpha3' => 'HKG', "name" => "Hong Kong",],
        "HU" => ['alpha2' => 'HU', 'alpha3' => 'HUN', "name" => "Hungary",],
        "IS" => ['alpha2' => 'IS', 'alpha3' => 'ISL', "name" => "Iceland",],
        "IN" => ['alpha2' => 'IN', 'alpha3' => 'IND', "name" => "India",],
        "ID" => ['alpha2' => 'ID', 'alpha3' => 'IDN', "name" => "Indonesia",],
        "IR" => ['alpha2' => 'IR', 'alpha3' => 'IRN', "name" => "Iran",],
        "IQ" => ['alpha2' => 'IQ', 'alpha3' => 'IRQ', "name" => "Iraq",],
        "IE" => ['alpha2' => 'IE', 'alpha3' => 'IRL', "name" => "Ireland",],
        "IM" => ['alpha2' => 'IM', 'alpha3' => 'IMN', "name" => "Isle of Man",],
        "IL" => ['alpha2' => 'IL', 'alpha3' => 'ISR', "name" => "Israel",],
        "IT" => ['alpha2' => 'IT', 'alpha3' => 'ITA', "name" => "Italy",],
        "JM" => ['alpha2' => 'JM', 'alpha3' => 'JAM', "name" => "Jamaica",],
        "JP" => ['alpha2' => 'JP', 'alpha3' => 'JPN', "name" => "Japan",],
        "JE" => ['alpha2' => 'JE', 'alpha3' => 'JEY', "name" => "Jersey",],
        "JO" => ['alpha2' => 'JO', 'alpha3' => 'JOR', "name" => "Jordan",],
        "KZ" => ['alpha2' => 'KZ', 'alpha3' => 'KAZ', "name" => "Kazakhstan",],
        "KE" => ['alpha2' => 'KE', 'alpha3' => 'KEN', "name" => "Kenya",],
        "KI" => ['alpha2' => 'KI', 'alpha3' => 'KIR', "name" => "Kiribati",],
        "KP" => ['alpha2' => 'KP', 'alpha3' => 'PRK', "name" => "Democratic People's Republic of Korea",],
        "KR" => ['alpha2' => 'KR', 'alpha3' => 'KOR', "name" => "Republic of Korea",],
        "KW" => ['alpha2' => 'KW', 'alpha3' => 'KWT', "name" => "Kuwait",],
        "KG" => ['alpha2' => 'KG', 'alpha3' => 'KGZ', "name" => "Kyrgyzstan",],
        "LA" => ['alpha2' => 'LA', 'alpha3' => 'LAO', "name" => "Lao People's Democratic Republic",],
        "LV" => ['alpha2' => 'LV', 'alpha3' => 'LVA', "name" => "Latvia",],
        "LB" => ['alpha2' => 'LB', 'alpha3' => 'LBN', "name" => "Lebanon",],
        "LS" => ['alpha2' => 'LS', 'alpha3' => 'LSO', "name" => "Lesotho",],
        "LR" => ['alpha2' => 'LR', 'alpha3' => 'LBR', "name" => "Liberia",],
        "LY" => ['alpha2' => 'LY', 'alpha3' => 'LBY', "name" => "Libya",],
        "LI" => ['alpha2' => 'LI', 'alpha3' => 'LIE', "name" => "Liechtenstein",],
        "LT" => ['alpha2' => 'LT', 'alpha3' => 'LTU', "name" => "Lithuania",],
        "LU" => ['alpha2' => 'LU', 'alpha3' => 'LUX', "name" => "Luxembourg",],
        "MO" => ['alpha2' => 'MO', 'alpha3' => 'MAC', "name" => "Macao",],
        "MK" => ['alpha2' => 'MK', 'alpha3' => 'MKD', "name" => "Macedonia",],
        "MG" => ['alpha2' => 'MG', 'alpha3' => 'MDG', "name" => "Madagascar",],
        "MW" => ['alpha2' => 'MW', 'alpha3' => 'MWI', "name" => "Malawi",],
        "MY" => ['alpha2' => 'MY', 'alpha3' => 'MYS', "name" => "Malaysia",],
        "MV" => ['alpha2' => 'MV', 'alpha3' => 'MDV', "name" => "Maldives",],
        "ML" => ['alpha2' => 'ML', 'alpha3' => 'MLI', "name" => "Mali",],
        "MT" => ['alpha2' => 'MT', 'alpha3' => 'MLT', "name" => "Malta",],
        "MH" => ['alpha2' => 'MH', 'alpha3' => 'MHL', "name" => "Marshall Islands",],
        "MQ" => ['alpha2' => 'MQ', 'alpha3' => 'MTQ', "name" => "Martinique",],
        "MR" => ['alpha2' => 'MR', 'alpha3' => 'MRT', "name" => "Mauritania",],
        "MU" => ['alpha2' => 'MU', 'alpha3' => 'MUS', "name" => "Mauritius",],
        "YT" => ['alpha2' => 'YT', 'alpha3' => 'MYT', "name" => "Mayotte",],
        "MX" => ['alpha2' => 'MX', 'alpha3' => 'MEX', "name" => "Mexico",],
        "FM" => ['alpha2' => 'FM', 'alpha3' => 'FSM', "name" => "Micronesia",],
        "MD" => ['alpha2' => 'MD', 'alpha3' => 'MDA', "name" => "Moldova",],
        "MC" => ['alpha2' => 'MC', 'alpha3' => 'MCO', "name" => "Monaco",],
        "MN" => ['alpha2' => 'MN', 'alpha3' => 'MNG', "name" => "Mongolia",],
        "ME" => ['alpha2' => 'ME', 'alpha3' => 'MNE', "name" => "Montenegro",],
        "MS" => ['alpha2' => 'MS', 'alpha3' => 'MSR', "name" => "Montserrat",],
        "MA" => ['alpha2' => 'MA', 'alpha3' => 'MAR', "name" => "Morocco",],
        "MZ" => ['alpha2' => 'MZ', 'alpha3' => 'MOZ', "name" => "Mozambique",],
        "MM" => ['alpha2' => 'MM', 'alpha3' => 'MMR', "name" => "Myanmar",],
        "NA" => ['alpha2' => 'NA', 'alpha3' => 'NAM', "name" => "Namibia",],
        "NR" => ['alpha2' => 'NR', 'alpha3' => 'NRU', "name" => "Nauru",],
        "NP" => ['alpha2' => 'NP', 'alpha3' => 'NPL', "name" => "Nepal",],
        "NL" => ['alpha2' => 'NL', 'alpha3' => 'NLD', "name" => "Netherlands",],
        "AN" => ['alpha2' => 'AN', 'alpha3' => 'ANT', "name" => "Netherlands Antilles",],
        "NC" => ['alpha2' => 'NC', 'alpha3' => 'NCL', "name" => "New Caledonia",],
        "NZ" => ['alpha2' => 'NZ', 'alpha3' => 'NZL', "name" => "New Zealand",],
        "NI" => ['alpha2' => 'NI', 'alpha3' => 'NIC', "name" => "Nicaragua",],
        "NE" => ['alpha2' => 'NE', 'alpha3' => 'NER', "name" => "Niger",],
        "NG" => ['alpha2' => 'NG', 'alpha3' => 'NGA', "name" => "Nigeria",],
        "NU" => ['alpha2' => 'NU', 'alpha3' => 'NIU', "name" => "Niue",],
        "NF" => ['alpha2' => 'NF', 'alpha3' => 'NFK', "name" => "Norfolk Island",],
        "MP" => ['alpha2' => 'MP', 'alpha3' => 'MNP', "name" => "Northern Mariana Islands",],
        "NO" => ['alpha2' => 'NO', 'alpha3' => 'NOR', "name" => "Norway",],
        "OM" => ['alpha2' => 'OM', 'alpha3' => 'OMN', "name" => "Oman",],
        "PK" => ['alpha2' => 'PK', 'alpha3' => 'PAK', "name" => "Pakistan",],
        "PW" => ['alpha2' => 'PW', 'alpha3' => 'PLW', "name" => "Palau",],
        "PS" => ['alpha2' => 'PS', 'alpha3' => 'PSE', "name" => "Palestinia",],
        "PA" => ['alpha2' => 'PA', 'alpha3' => 'PAN', "name" => "Panama",],
        "PG" => ['alpha2' => 'PG', 'alpha3' => 'PNG', "name" => "Papua New Guinea",],
        "PY" => ['alpha2' => 'PY', 'alpha3' => 'PRY', "name" => "Paraguay",],
        "PE" => ['alpha2' => 'PE', 'alpha3' => 'PER', "name" => "Peru",],
        "PH" => ['alpha2' => 'PH', 'alpha3' => 'PHL', "name" => "Philippines",],
        "PN" => ['alpha2' => 'PN', 'alpha3' => 'PCN', "name" => "Pitcairn",],
        "PL" => ['alpha2' => 'PL', 'alpha3' => 'POL', "name" => "Poland",],
        "PT" => ['alpha2' => 'PT', 'alpha3' => 'PRT', "name" => "Portugal",],
        "PR" => ['alpha2' => 'PR', 'alpha3' => 'PRI', "name" => "Puerto Rico",],
        "QA" => ['alpha2' => 'QA', 'alpha3' => 'QAT', "name" => "Qatar",],
        "RE" => ['alpha2' => 'RE', 'alpha3' => 'REU', "name" => "Reunion",],
        "RO" => ['alpha2' => 'RO', 'alpha3' => 'ROU', "name" => "Romania",],
        "RU" => ['alpha2' => 'RU', 'alpha3' => 'RUS', "name" => "Russian Federation",],
        "RW" => ['alpha2' => 'RW', 'alpha3' => 'RWA', "name" => "Rwanda",],
        "SH" => ['alpha2' => 'SH', 'alpha3' => 'SHN', "name" => "Saint Helena",],
        "KN" => ['alpha2' => 'KN', 'alpha3' => 'KNA', "name" => "Saint Kitts and Nevis",],
        "LC" => ['alpha2' => 'LC', 'alpha3' => 'LCA', "name" => "Saint Lucia",],
        "PM" => ['alpha2' => 'PM', 'alpha3' => 'SPM', "name" => "Saint Pierre and Miquelon",],
        "VC" => ['alpha2' => 'VC', 'alpha3' => 'VCT', "name" => "Saint Vincent and The Grenadines",],
        "WS" => ['alpha2' => 'WS', 'alpha3' => 'WSM', "name" => "Samoa",],
        "SM" => ['alpha2' => 'SM', 'alpha3' => 'SMR', "name" => "San Marino",],
        "ST" => ['alpha2' => 'ST', 'alpha3' => 'STP', "name" => "Sao Tome and Principe",],
        "SA" => ['alpha2' => 'SA', 'alpha3' => 'SAU', "name" => "Saudi Arabia",],
        "SN" => ['alpha2' => 'SN', 'alpha3' => 'SEN', "name" => "Senegal",],
        "RS" => ['alpha2' => 'RS', 'alpha3' => 'SRB', "name" => "Serbia",],
        "SC" => ['alpha2' => 'SC', 'alpha3' => 'SYC', "name" => "Seychelles",],
        "SL" => ['alpha2' => 'SL', 'alpha3' => 'SLE', "name" => "Sierra Leone",],
        "SG" => ['alpha2' => 'SG', 'alpha3' => 'SGP', "name" => "Singapore",],
        "SK" => ['alpha2' => 'SK', 'alpha3' => 'SVK', "name" => "Slovakia",],
        "SI" => ['alpha2' => 'SI', 'alpha3' => 'SVN', "name" => "Slovenia",],
        "SB" => ['alpha2' => 'SB', 'alpha3' => 'SLB', "name" => "Solomon Islands",],
        "SO" => ['alpha2' => 'SO', 'alpha3' => 'SOM', "name" => "Somalia",],
        "ZA" => ['alpha2' => 'ZA', 'alpha3' => 'ZAF', "name" => "South Africa",],
        "SS" => ['alpha2' => 'SS', 'alpha3' => 'SSD', "name" => "South Sudan",],
        "GS" => ['alpha2' => 'GS', 'alpha3' => 'SGS', "name" => "South Georgia and The South Sandwich Islands",],
        "ES" => ['alpha2' => 'ES', 'alpha3' => 'ESP', "name" => "Spain",],
        "LK" => ['alpha2' => 'LK', 'alpha3' => 'LKA', "name" => "Sri Lanka",],
        "SD" => ['alpha2' => 'SD', 'alpha3' => 'SDN', "name" => "Sudan",],
        "SR" => ['alpha2' => 'SR', 'alpha3' => 'SUR', "name" => "Suriname",],
        "SJ" => ['alpha2' => 'SJ', 'alpha3' => 'SJM', "name" => "Svalbard and Jan Mayen",],
        "SZ" => ['alpha2' => 'SZ', 'alpha3' => 'SWZ', "name" => "Swaziland",],
        "SE" => ['alpha2' => 'SE', 'alpha3' => 'SWE', "name" => "Sweden",],
        "CH" => ['alpha2' => 'CH', 'alpha3' => 'CHE', "name" => "Switzerland",],
        "SY" => ['alpha2' => 'SY', 'alpha3' => 'SYR', "name" => "Syrian Arab Republic",],
        "TW" => ['alpha2' => 'TW', 'alpha3' => 'TWN', "name" => "Taiwan, Province of China",],
        "TJ" => ['alpha2' => 'TJ', 'alpha3' => 'TJK', "name" => "Tajikistan",],
        "TZ" => ['alpha2' => 'TZ', 'alpha3' => 'TZA', "name" => "Tanzania, United Republic of",],
        "TH" => ['alpha2' => 'TH', 'alpha3' => 'THA', "name" => "Thailand",],
        "TL" => ['alpha2' => 'TL', 'alpha3' => 'TLS', "name" => "Timor-leste",],
        "TG" => ['alpha2' => 'TG', 'alpha3' => 'TGO', "name" => "Togo",],
        "TK" => ['alpha2' => 'TK', 'alpha3' => 'TKL', "name" => "Tokelau",],
        "TO" => ['alpha2' => 'TO', 'alpha3' => 'TON', "name" => "Tonga",],
        "TT" => ['alpha2' => 'TT', 'alpha3' => 'TTO', "name" => "Trinidad and Tobago",],
        "TN" => ['alpha2' => 'TN', 'alpha3' => 'TUN', "name" => "Tunisia",],
        "TR" => ['alpha2' => 'TR', 'alpha3' => 'TUR', "name" => "Turkey",],
        "TM" => ['alpha2' => 'TM', 'alpha3' => 'TKM', "name" => "Turkmenistan",],
        "TC" => ['alpha2' => 'TC', 'alpha3' => 'TCA', "name" => "Turks and Caicos Islands",],
        "TV" => ['alpha2' => 'TV', 'alpha3' => 'TUV', "name" => "Tuvalu",],
        "UG" => ['alpha2' => 'UG', 'alpha3' => 'UGA', "name" => "Uganda",],
        "UA" => ['alpha2' => 'UA', 'alpha3' => 'UKR', "name" => "Ukraine",],
        "AE" => ['alpha2' => 'AE', 'alpha3' => 'ARE', "name" => "United Arab Emirates",],
        "GB" => ['alpha2' => 'GB', 'alpha3' => 'GBR', "name" => "United Kingdom",],
        "US" => ['alpha2' => 'US', 'alpha3' => 'USA', "name" => "United States",],
        "UM" => ['alpha2' => 'UM', 'alpha3' => 'UMI', "name" => "United States Minor Outlying Islands",],
        "UY" => ['alpha2' => 'UY', 'alpha3' => 'URY', "name" => "Uruguay",],
        "UZ" => ['alpha2' => 'UZ', 'alpha3' => 'UZB', "name" => "Uzbekistan",],
        "VU" => ['alpha2' => 'VU', 'alpha3' => 'VUT', "name" => "Vanuatu",],
        "VE" => ['alpha2' => 'VE', 'alpha3' => 'VEN', "name" => "Venezuela",],
        "VN" => ['alpha2' => 'VN', 'alpha3' => 'VNM', "name" => "Vietnam",],
        "VG" => ['alpha2' => 'VG', 'alpha3' => 'VGB', "name" => "Virgin Islands, British",],
        "VI" => ['alpha2' => 'VI', 'alpha3' => 'VIR', "name" => "Virgin Islands, U.S.",],
        "WF" => ['alpha2' => 'WF', 'alpha3' => 'WLF', "name" => "Wallis and Futuna",],
        "EH" => ['alpha2' => 'EH', 'alpha3' => 'ESH', "name" => "Western Sahara",],
        "YE" => ['alpha2' => 'YE', 'alpha3' => 'YEM', "name" => "Yemen",],
        "ZM" => ['alpha2' => 'ZM', 'alpha3' => 'ZMB', "name" => "Zambia",],
        "ZW" => ['alpha2' => 'ZW', 'alpha3' => 'ZWE', "name" => "Zimbabwe",],
    ];
    /**
     * validated
     *
     * @var boolean
     */
    private $validated;
    /**
     * line 1
     *
     * @var string
     */
    private $line1;
    /**
     * line 2
     *
     * @var string
     */
    private $line2;
    /**
     * line 3
     *
     * @var string
     */
    private $line3;
    /**
     * city
     *
     * @var string
     */
    private $city;
    /**
     * postalCode
     *
     * @var string
     */
    private $postalCode;
    /**
     * country ISO 3166-1 alpha-2
     *
     * @var string
     */
    private $countryISO2;
    /**
     * country ISO 3166-1 alpha-3
     *
     * @var string
     */
    private $country;
    /**
     * country name
     *
     * @var string
     */
    private $countryName;

    /**
     * Convert a two or three letter code to an array of country details.
     * @param string $code
     * @return array
     */
    public static function mapISOCountryCode($code)
    {
        // Upper case the string for comparison.
        $code = strtoupper($code);
        if (strlen($code) === 2 && isset(self::$countries[$code])) {
            return self::$countries[$code];
        }
        elseif (strlen($code) === 3) {
            foreach(self::$countries as $country) {
                if ($code == $country['alpha3']) {
                    return $country;
                }
            }
        }
        throw new EWSClientError('Country code must be two or three letters.');
    }


    /**
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @param boolean $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    /**
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * @param string $line1
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;
    }

    /**
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * @param string $line2
     */
    public function setLine2($line2)
    {
        $this->line2 = $line2;
    }

    /**
     * @return string
     */
    public function getLine3()
    {
        return $this->line3;
    }

    /**
     * @param string $line3
     */
    public function setLine3($line3)
    {
        $this->line3 = $line3;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCountryISO2()
    {
        return $this->countryISO2;
    }

    /**
     * @param string $countryISO2
     */
    public function setCountryISO2($countryISO2)
    {
        $this->countryISO2 = $countryISO2;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $country_details = self::mapISOCountryCode($country);
        $this->country = $country_details['alpha3'];
        $this->setCountryISO2($country_details['alpha2']);
        $this->setCountryName($country_details['name']);
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    }

    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    protected function getIdKey()
    {
        // We do not actually need this for this particular class, although it's staying as it's required, and it's also
        // possible that the EWS could be altered to allow this (creating a single address for multiple participants).
        throw new EWSClientError('Unable to update Address directly');
    }

    /**
     * Simple function to return the URI that should be used to GET this object
     * from the EWS.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    protected function getUri()
    {
        // Same issue as getIdKey().
        throw new EWSClientError('Unable to update Address directly');
    }

    /**
     * Simple function to return the URI that should be used to POST/UPDATE this object
     * from the EWS.
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    protected function getCreateUri()
    {
        // Same issue as getIdKey().
        throw new EWSClientError('Unable to update Address directly');
    }

    /**
     * Simple function to return the structure of the class. This defines how the
     * object should be built and delivered as an array.
     *
     * @return array
     */
    protected function getArrayStructure()
    {
        return [
            'validated',
            'line1',
            'line2',
            'line3',
            'city',
            'postalCode',
            'country',
        ];
    }
}

