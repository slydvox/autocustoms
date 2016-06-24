<?php

namespace App\Http\Controllers;

use App\PurchaseOrder;

class EdiController extends Controller
{

    protected $_sDelimiter = "*";
    protected $_sLineEnd = "~";
    protected $_sReturn = "\r\n";
    protected $_sDateString;
    protected $_sTimeString;

    public function __construct()
    {
        $this->_sDateString = date("Ymd");
        $this->_sTimeString = date("Hi");

    }

    /**
     * This method creates all Edi text lines using various input data containing values and their line positions.
     *
     * @param $aData
     * @return string
     * 
     */
    public function createEdiLine($aData)
    {
        // Start the text line
        $sLine = $aData["prefix"];
        $iTotalPositions = $aData["total_positions"];
        $aDataElements = $aData["data"];

        $iKey = 0;
        for($i = 0; $i < $iTotalPositions; $i++) {

            $sLine .= $this->_sDelimiter;
            $iCurrentPosition = isset($aDataElements[$iKey]["position"]) ? (int)$aDataElements[$iKey]["position"] : null;

            // If there is a record at this position
            if($iCurrentPosition == $i) {
                $sLine .= $aDataElements[$iKey]["value"];
                $iKey++;
            }
        }

        return $sLine;
    }

    /**
     * Beginning line
     * @param $oPurchaseOrder
     * @return string
     *
     */
    public function createBeg($oPurchaseOrder)
    {
        $aDataElements = [
            "prefix" => "BEG",
            "total_positions" => 5,
            "data" => [
                [
                    "position" => 0,
                    "value" => $oPurchaseOrder->purpose,
                ],
                [
                    "position" => 1,
                    "value" => $oPurchaseOrder->type,
                ],
                [
                    "position" => 2,
                    "value" => $oPurchaseOrder->number,
                ],
                [
                    "position" => 4,
                    "value" => $oPurchaseOrder->date,
                ],
            ]
        ];

        $sBegLine = $this->createEdiLine($aDataElements) . $this->_sReturn;

        return $sBegLine;
    }

    /**
     * Create the currency type
     * @param $oPurchaseOrder
     * @return string
     */
    public function createCur($oPurchaseOrder)
    {
        $aDataElements = [
            "prefix" => "CUR",
            "total_positions" => 2,
            "data" => [
                [
                    "position" => 0,
                    "value" => $oPurchaseOrder->purchaser,
                ],
                [
                    "position" => 1,
                    "value" => $oPurchaseOrder->currency_code,
                ],
            ]
        ];

        $sCurLine = $this->createEdiLine($aDataElements) . $this->_sReturn;

        return $sCurLine;
    }

    /**
     * Reference line looping
     *
     * @param $aPoReferences
     * @return string
     *
     */
    public function createRef($aPoReferences)
    {
        $aRefDataLines = array();
        foreach($aPoReferences as $aPoReference) {
            $aRefDataLines[] = [
                [
                    "position" => 0,
                    "value" => $aPoReference->code,
                ],
                [
                    "position" => 1,
                    "value" => $aPoReference->value,
                ],

            ];
        }
        
        $sRefLines = "";
        foreach($aRefDataLines as $aRefDataLine) {
            $aRefDataElements = [
                "prefix" => "REF",
                "total_positions" => 2,
                "data" => $aRefDataLine,
            ];

            $sRefLines .= $this->createEdiLine($aRefDataElements) . $this->_sReturn;
        }

        return $sRefLines;
    }

    /**
     * Sac data line looping
     *
     * @param $aPoSacs
     * @return string
     *
     */
    public function createSac($aPoSacs)
    {
        $aSacDataLines = array();
        foreach($aPoSacs as $aPoSac) {
            $aSacDataLines[] = [
                [
                    "position" => 0,
                    "value" => $aPoSac->indicator,
                ],
                [
                    "position" => 1,
                    "value" => $aPoSac->code,
                ],
                [
                    "position" => 5,
                    "value" => $aPoSac->amount,
                ],

            ];
        }

        $sSacLines = "";
        foreach($aSacDataLines as $aSacDataLine) {
            $aSacDataElements = [
                "prefix" => "SAC",
                "total_positions" => 15,
                "data" => $aSacDataLine,
            ];

            $sSacLines .= $this->createEdiLine($aSacDataElements) . $this->_sReturn;
        }

        return $sSacLines;
    }

    /**
     * Create ITD line
     *
     * @param $oPurchaseOrder
     * @return string
     *
     */
    public function createItd($oPurchaseOrder)
    {
        $aDataElements = [
            "prefix" => "ITD",
            "total_positions" => 11,
            "data" => [
                [
                    "position" => 0,
                    "value" => $oPurchaseOrder->terms_type_code,
                ],
                [
                    "position" => 1,
                    "value" => $oPurchaseOrder->terms_basis_date_code,
                ],
            ]
        ];

        $sItdLine = $this->createEdiLine($aDataElements) . $this->_sReturn;

        return $sItdLine;
    }

    /**
     * Date and time qualifiers
     * @param $oPurchaseOrder
     * @return string
     *
     */
    public function createDtm($oPurchaseOrder)
    {
        $aDataElements = [
            "prefix" => "DTM",
            "total_positions" => 11,
            "data" => [
                [
                    "position" => 0,
                    "value" => $oPurchaseOrder->date_time_qualifier,
                ],
                [
                    "position" => 1,
                    "value" => $oPurchaseOrder->qualifier_date,
                ],
            ]
        ];

        $sDtmLine = $this->createEdiLine($aDataElements) . $this->_sReturn;

        return $sDtmLine;
    }

    /**
     * Create TD5 line (Transportation)
     *
     * @param $oPurchaseOrder
     * @return string
     *
     */
    public function createTd5($oPurchaseOrder)
    {
        $aDataElements = [
            "prefix" => "TD5",
            "total_positions" => 13,
            "data" => [
                [
                    "position" => 3,
                    "value" => $oPurchaseOrder->transportation_type_code,
                ],
                [
                    "position" => 4,
                    "value" => $oPurchaseOrder->routing,
                ],
                [
                    "position" => 11,
                    "value" => $oPurchaseOrder->service_level_code_1,
                ],
                [
                    "position" => 12,
                    "value" => $oPurchaseOrder->service_level_code_2,
                ],
            ]
        ];

        $sTd5Line = $this->createEdiLine($aDataElements) . $this->_sReturn;

        return $sTd5Line;
    }

    /**
     * N(x) Blocks - These block lines area created for each "Bill To, Ship To" address ID entries if they exist.
     *
     * @param $aNamingBlockTypes
     * @return string
     *
     */
    public function createNamingBlock($aNamingBlockTypes)
    {
        $sNBlockLine = "";
        foreach($aNamingBlockTypes as $aNamingBlockType)
        {
            $oPoAddress = $aNamingBlockType["data"];
            $sType = $aNamingBlockType["symbol"];

            $aN1DataElements = [
                "prefix" => "N1",
                "total_positions" => 2,
                "data" => [
                    [
                        "position" => 0,
                        "value" => $sType,
                    ],
                    [
                        "position" => 1,
                        "value" => $oPoAddress->user->name,
                    ],
                ]
            ];
            $sNBlockLine .= $this->createEdiLine($aN1DataElements) . $this->_sReturn;

            $aN2DataElements = [
                "prefix" => "N3",
                "total_positions" => 2,
                "data" => [
                    [
                        "position" => 0,
                        "value" => $oPoAddress->address,
                    ],
                    [
                        "position" => 1,
                        "value" => $oPoAddress->address2,
                    ],
                ]
            ];
            $sNBlockLine .= $this->createEdiLine($aN2DataElements) . $this->_sReturn;

            $aN3DataElements = [
                "prefix" => "N4",
                "total_positions" => 4,
                "data" => [
                    [
                        "position" => 0,
                        "value" => $oPoAddress->city,
                    ],
                    [
                        "position" => 1,
                        "value" => $oPoAddress->state,
                    ],
                    [
                        "position" => 2,
                        "value" => $oPoAddress->zip,
                    ],
                    [
                        "position" => 3,
                        "value" => $oPoAddress->country,
                    ],
                ]
            ];
            $sNBlockLine .= $this->createEdiLine($aN3DataElements) . $this->_sReturn;

            if($sType != "VN") {
                $aPerDataElements = [
                    "prefix" => "PER",
                    "total_positions" => 6,
                    "data" => [
                        [
                            "position" => 0,
                            "value" => "IC",
                        ],
                        [
                            "position" => 1,
                            "value" => $oPoAddress->user->name,
                        ],
                        [
                            "position" => 2,
                            "value" => "TE",
                        ],
                        [
                            "position" => 3,
                            "value" => $oPoAddress->user->phone,
                        ],
                        [
                            "position" => 4,
                            "value" => "EM",
                        ],
                        [
                            "position" => 5,
                            "value" => $oPoAddress->user->email,
                        ],
                    ]
                ];
                $sNBlockLine .= $this->createEdiLine($aPerDataElements) . $this->_sReturn;
            }

        }

        return $sNBlockLine;
    }

    /**
     * Basic item line data
     *
     * @param $oPurchaseOrder
     * @return string
     *
     */
    public function createItemData($oPurchaseOrder)
    {
        $aPerDataElements = [
            "prefix" => "P01",
            "total_positions" => 11,
            "data" => [
                [
                    "position" => 0,
                    "value" => $oPurchaseOrder->assigned_id,
                ],
                [
                    "position" => 1,
                    "value" => $oPurchaseOrder->quantity,
                ],
                [
                    "position" => 2,
                    "value" => $oPurchaseOrder->unit_measure,
                ],
                [
                    "position" => 3,
                    "value" => $oPurchaseOrder->unit_price,
                ],
                [
                    "position" => 5,
                    "value" => $oPurchaseOrder->id_qualifier,
                ],
                [
                    "position" => 6,
                    "value" => $oPurchaseOrder->item_id,
                ],
                [
                    "position" => 7,
                    "value" => $oPurchaseOrder->id_qualifier2,
                ],
                [
                    "position" => 8,
                    "value" => $oPurchaseOrder->item_id2,
                ],
                [
                    "position" => 9,
                    "value" => $oPurchaseOrder->code,
                ],

            ]
        ];
        $sItemDataLine = $this->createEdiLine($aPerDataElements) . $this->_sReturn;

        return $sItemDataLine;
    }

    /**
     * Create PID line - Product description
     *
     * @param $oPurchaseOrder
     * @return string
     *
     */
    public function createPid($oPurchaseOrder)
    {
        $aPidDataElements = [
            "prefix" => "PID",
            "total_positions" => 5,
            "data" => [
                [
                    "position" => 0,
                    "value" => $oPurchaseOrder->item_description_code,
                ],
                [
                    "position" => 1,
                    "value" => $oPurchaseOrder->item_class_code,
                ],
                [
                    "position" => 4,
                    "value" => $oPurchaseOrder->item_description,
                ],
            ]
        ];
        $sPIDLine = $this->createEdiLine($aPidDataElements) . $this->_sReturn;

        return $sPIDLine;
    }

    /**
     * This method compiles all of the text lines from the above methods and outputs to both the browser and target text
     * file. Note: Line breaks are set to read correctly in the output text file using $_sLineEnd value of "\r\n".
     * If a readable format is desired for browser view, modify the global class var $_sLineEnd value to "<br />".
     *
     * @param $id
     * @param PurchaseOrder $oPurchaseOrders
     * @return string
     *
     */
    public function createPurchaseOrderEdi($id, PurchaseOrder $oPurchaseOrders)
    {

        $iRandomId = rand(1000000000,9999999999);
        // Retrieve the purchase order.
        $oPurchaseOrder = $oPurchaseOrders::find($id);
        if(empty($oPurchaseOrder)) {
            echo "No P.O. found.";
            exit;
        }

        // Begin gathering data fot the N(x) block lines and store them into the array.
        $aNamingBlockTypes = array();

        $oPoVendorAddress = $oPurchaseOrder->vendorAddress;
        $oPoBillAddress = $oPurchaseOrder->billAddress;
        $oPoShipAddress = $oPurchaseOrder->shipAddress;
        $oPoSoldAddress = $oPurchaseOrder->soldAddress;
        
        if($oPoBillAddress != null) {
            array_push($aNamingBlockTypes, array(
                "symbol" => "BT",
                "data" => $oPoBillAddress));
        }
        if($oPoShipAddress != null) {
            array_push($aNamingBlockTypes, array(
                "symbol" => "ST",
                "data" => $oPoShipAddress));
        }
        if($oPoSoldAddress != null) {
            array_push($aNamingBlockTypes, array(
                "symbol" => "SO",
                "data" => $oPoSoldAddress));
        }

        array_push($aNamingBlockTypes, array(
            "symbol" => "VN",
            "data" => $oPoVendorAddress));

        // After the array of active naming blocks has been compiled, build the text blocks lines.
        $sNamingBlocks = "";
        $sNamingBlocks .= $this->createNamingBlock($aNamingBlockTypes);

        // Start line. This line used a randomly generated 10 digit number (may not be proper) in the starting format line.
        $sStLine = "ST" . $this->_sDelimiter . "850" . $this->_sDelimiter . $iRandomId . $this->_sReturn;
        $sEdiBegLine = $this->createBeg($oPurchaseOrder);
        $sCurLine = $this->createCur($oPurchaseOrder);

        // Get all Ref data for this PO. Then pass then to create the lines
        $aPoReferences = $oPurchaseOrder->poReferences;
        $sRefLines = $this->createRef($aPoReferences);

        // Get all Sac data for this PO. Then pass then to create the lines
        $aPoSacs = $oPurchaseOrder->poSacs;
        $sSacLines = $this->createSac($aPoSacs);

        // Create these Edi lines based on the PO data
        $sItdLine = $this->createItd($oPurchaseOrder);
        $sDtmLine = $this->createDtm($oPurchaseOrder);
        $sTd5Line = $this->createTd5($oPurchaseOrder);
        $sItemDataLine = $this->createItemData($oPurchaseOrder);
        $sPidLine = $this->createPid($oPurchaseOrder);
        $sCttLine = "CTT" . $this->_sDelimiter . "1" . $this->_sReturn; // One transaction

        // First line of the Edi
        $sIsaLine =
            "ISA" . $this->_sDelimiter . "00" . $this->_sDelimiter .
            "\t" . $this->_sDelimiter . "00" . $this->_sDelimiter .
            "\t" . $this->_sDelimiter . "ZZ" . $this->_sDelimiter .
            "TRUCKXL" . "\t" . $this->_sDelimiter . "12" . $this->_sDelimiter .
            "7346778409" . $this->_sDelimiter . "160523" . $this->_sTimeString . $this->_sDelimiter .
            "U" . $this->_sDelimiter . "05010" . $this->_sDelimiter . "000000001" . $this->_sDelimiter .
            "0" . $this->_sDelimiter . "P" . $this->_sDelimiter . ">" . $this->_sReturn;

        // Begin to build the main parts of the EDI
        $sGsLine =
            "GS" . $this->_sDelimiter .
            "PO" . $this->_sDelimiter .
            "TRUCKXL" . $this->_sDelimiter .
            "6056649304" . $this->_sDelimiter .
            $this->_sDateString . $this->_sDelimiter .
            $this->_sTimeString . $this->_sDelimiter .
            "1" . $this->_sDelimiter .
            "X" .$this->_sDelimiter .
            "005010" . $this->_sReturn;

        // Assemble the main body lines that will be totaled in the SE line
        $sEdiBody =
            $sStLine .
            $sEdiBegLine .
            $sCurLine .
            $sRefLines .
            $sSacLines .
            $sItdLine .
            $sDtmLine .
            $sTd5Line .
            $sNamingBlocks .
            $sItemDataLine .
            $sPidLine .
            $sCttLine;

        /**
         * Count the lines based on which ever line ending characters are being used. In order to have proper line count,
         * We need to know which line break type is currently active.
         *
         */
        $lines_arr = $this->_sReturn == "<br />" ? preg_split("/(<br \/>)/", $sEdiBody) : preg_split("/\r/\n", $sEdiBody);
        $iTotalLines = count($lines_arr);

        $sSeLine = "SE" . $this->_sDelimiter . $iTotalLines . $this->_sDelimiter . $iRandomId . $this->_sReturn;
        $sGeLine = "GE" . $this->_sDelimiter . "1" . $this->_sDelimiter . "1" . $this->_sReturn;
        $sIeaLine = "IEA" . $this->_sDelimiter . "1" . $this->_sDelimiter . "000000001";

        // Build the final Edi string
        $sPoEdi = $sIsaLine . $sGsLine . $sEdiBody . $sSeLine . $sGeLine . $sIeaLine;

        $path = storage_path();
        $ediFile = fopen($path . "/app/public/purchase_order_edi.txt", "w") or die("Unable to open file!");
        fwrite($ediFile, $sPoEdi);
        fclose($ediFile);


        return $sPoEdi;
    }

}
