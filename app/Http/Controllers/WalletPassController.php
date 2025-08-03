<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Thenextweb\PassGenerator;


class WalletPassController extends Controller
{
    public function generateApplePass(User $user)
    {
        $pass_identifier = '1002';  // This, if set, it would allow for retrieval later on of the created Pass

        $pass = new PassGenerator($pass_identifier);

        $pass_definition = [
            "description"       => "description",
            "formatVersion"     => 1,
            "organizationName"  => "velvet-vehicle",
            "passTypeIdentifier" => "pass.com.velvet-vehicle.loyalty",
            "serialNumber"      => "123456",
            "teamIdentifier"    => env('APPLE_TEAM_ID'),
            "foregroundColor"   => "rgb(99, 99, 99)",
            "backgroundColor"   => "rgb(212, 212, 212)",
            "barcode" => [
                "message"   => "encodedmessageonQR",
                "format"    => "PKBarcodeFormatQR",
                "altText"   => "altextfortheQR",
                "messageEncoding" => "utf-8",
            ],
            "boardingPass" => [
                "headerFields" => [
                    [
                        "key" => "destinationDate",
                        "label" => "Trip to: BCN-SANTS",
                        "value" => "15/09/2015"
                    ]
                ],
                "primaryFields" => [
                    [
                        "key" => "boardingTime",
                        "label" => "MURCIA",
                        "value" => "13:54",
                        "changeMessage" => "Boarding time has changed to %@"
                    ],
                    [
                        "key" => "destination",
                        "label" => "BCN-SANTS",
                        "value" => "21:09"
                    ]

                ],
                "secondaryFields" => [
                    [
                        "key" => "passenger",
                        "label" => "Passenger",
                        "value" => "J.DOE"
                    ],
                    [
                        "key" => "bookingref",
                        "label" => "Booking Reference",
                        "value" => "4ZK6FG"
                    ]
                ],
                "auxiliaryFields" => [
                    [
                        "key" => "train",
                        "label" => "Train TALGO",
                        "value" => "00264"
                    ],
                    [
                        "key" => "car",
                        "label" => "Car",
                        "value" => "009"
                    ],
                    [
                        "key" => "seat",
                        "label" => "Seat",
                        "value" => "04A"
                    ],
                    [
                        "key" => "classfront",
                        "label" => "Class",
                        "value" => "Tourist"
                    ]
                ],
                "backFields" => [
                    [
                        "key" => "ticketNumber",
                        "label" => "Ticket Number",
                        "value" => "7612800569875"
                    ],
                    [
                        "key" => "passenger-name",
                        "label" => "Passenger",
                        "value" => "John Doe"
                    ],
                    [
                        "key" => "classback",
                        "label" => "Class",
                        "value" => "Tourist"
                    ]
                ],
                "locations" => [
                    [
                        "latitude" => 37.97479,
                        "longitude" => -1.131522,
                        "relevantText" => "Departure station"
                    ]
                ],
                "transitType" => "PKTransitTypeTrain"
            ],
        ];

        $pass->setPassDefinition($pass_definition);

        // Definitions can also be set from a JSON string
        // $pass->setPassDefinition(file_get_contents('/path/to/pass.json));

        // Add assets to the PKPass package
        // $pass->addAsset(base_path('public/images/wallet/background.png'));
        // $pass->addAsset(base_path('public/images/wallet/thumbnail.png'));
        $pass->addAsset(base_path('public/images/wallet/icon.png'));
        $pass->addAsset(base_path('public/images/wallet/logo.png'));

        $pkpass = $pass->create();


        return response($pkpass, 200, [
            'Content-Transfer-Encoding' => 'binary',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="pass.pkpass"',
            'Content-length' => strlen($pkpass),
            'Content-Type' => PassGenerator::getPassMimeType(),
            'Pragma' => 'no-cache',
        ]);
    }
}
