<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ups extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->database();
        $this->CI = & get_instance();

        $this->load->library(array('ups_lib'));
        $this->load->model(array('common_model', 'zipcode'));
        $this->load->helper('url');
        // $this->load->library('flexi_cart');
//        $this->load->model('common_model');
//        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
//        /* Load Backend model */
//        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
//        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));
//
//        $this->lang->load('auth');
//        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'backend/coupon_category', 'backend/coupon_method', 'backend/coupon_method_tax', 'backend/coupon_group', 'common_model', 'Common_model_marketing'));
//        $this->flexi = new stdClass;
//        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));
//        $this->load->library('flexi_cart');
//        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details', 'demo_cart_admin_model'));
    }

    public function getRates() {        
        
        $zipcode_val = $this->input->post('zipcode');
        $getshippinginfo = $this->zipcode->getRatesByZipcode($zipcode_val);


        if(!empty($getshippinginfo)) {
        
            $selected_city = trim($getshippinginfo[0]['city_name']);
            $this->session->set_userdata('customer_zipcode', $zipcode_val);
            
            //create soap request
            $option['RequestOption'] = 'Shop';
            $request['Request'] = $option;

            $pickuptype['Code'] = '01';
            $pickuptype['Description'] = 'Daily Pickup';
            $request['PickupType'] = $pickuptype;

            $customerclassification['Code'] = '01';
            $customerclassification['Description'] = 'Classfication';
            $request['CustomerClassification'] = $customerclassification;

            $shipper['Name'] = '';
            $shipper['ShipperNumber'] = '2734W3';
            $address['AddressLine'] = array
                (
                '',
                '',
                ''
            );
            $address['City'] = 'Miami';
            $address['StateProvinceCode'] = 'FL';
            $address['PostalCode'] = '33156';
            $address['CountryCode'] = 'US';
            $shipper['Address'] = $address;
            $shipment['Shipper'] = $shipper;

            $shipto['Name'] = '';
            $addressTo['AddressLine'] = '';
            $addressTo['City'] = $getshippinginfo[0]['city_name'];
            $addressTo['StateProvinceCode'] = $getshippinginfo[0]['state_ext'];
            $addressTo['PostalCode'] = $getshippinginfo[0]['zipcode'];
            $addressTo['CountryCode'] = 'US';
            $addressTo['ResidentialAddressIndicator'] = '';
            $shipto['Address'] = $addressTo;
            $shipment['ShipTo'] = $shipto;

            $shipfrom['Name'] = '';
            $addressFrom['City'] = 'Miami';
            $addressFrom['StateProvinceCode'] = 'FL';
            $addressFrom['PostalCode'] = '33156';
            $addressFrom['CountryCode'] = 'US';
            $shipfrom['Address'] = $addressFrom;
            $shipment['ShipFrom'] = $shipfrom;

            $service['Code'] = '03';
            $service['Description'] = 'Service Code';
            $shipment['Service'] = $service;

            $packaging1['Code'] = '02';
            $packaging1['Description'] = 'Rate';
            $package1['PackagingType'] = $packaging1;
            $dunit1['Code'] = 'IN';
            $dunit1['Description'] = 'inches';
            $dimensions1['Length'] = '5';
            $dimensions1['Width'] = '4';
            $dimensions1['Height'] = '10';
            $dimensions1['UnitOfMeasurement'] = $dunit1;
            $package1['Dimensions'] = $dimensions1;
            $punit1['Code'] = 'LBS';
            $punit1['Description'] = 'Pounds';
            $packageweight1['Weight'] = '0.5';
            $packageweight1['UnitOfMeasurement'] = $punit1;
            $package1['PackageWeight'] = $packageweight1;

            $shipment['Package'] = array($package1);
            $shipment['ShipmentServiceOptions'] = '';
            $shipment['LargePackageIndicator'] = '';
            $request['Shipment'] = $shipment;

            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
            
            // if ($this->data['cart_summary']['item_summary_total'] < 250) {
            //     $rate = $this->ups_lib->getShipRates($request);
            //     $shippingRate = $rate->RatedShipment[0]->TotalCharges->MonetaryValue;
            //     $_SESSION['flexi_cart']['summary']['shipping_total'] = $shippingRate;
            // } else {
            //     $shippingRate = "Free";
            // }

            $rate = $this->ups_lib->getShipRates($request);
            
            $shippingRate = $rate->RatedShipment[0]->TotalCharges->MonetaryValue;
            $_SESSION['flexi_cart']['summary']['shipping_total'] = $shippingRate;

            // if ($getshippinginfo[0]['state_ext'] == 'GA') {
                $tax = $this->data['cart_summary']['item_summary_total'] * 7 / 100;
                $_SESSION['flexi_cart']['summary']['tax_total'] = $tax;
                $_SESSION['flexi_cart']['summary']['zipcode'] = $zipcode_val;
                $_SESSION['flexi_cart']['summary']['selected_city'] = $selected_city;
                $_SESSION['flexi_cart']['summary']['shipping_total'] = $shippingRate;

            // } else {
            //     $tax = "0.00";
            //     $_SESSION['flexi_cart']['summary']['tax_total'] = 0;
            // }
            
            // $total = $this->data['cart_summary']['item_summary_total'] + $rate->RatedShipment[0]->TotalCharges->MonetaryValue + $tax;

            // $this->session->set_userdata('flexi_cart')['shipping_total'] = $rate->RatedShipment[0]->TotalCharges->MonetaryValue;
            // $this->session->set_userdata('flexi_cart')['shipping_total'] = $shippingRate;
            redirect('home/cart');
            // echo json_encode(array('status' => '1', 'data' => $shippingRate, 'tax' => $tax, 'total' => "$".$total));
        } else {
            $this->session->set_userdata('error', 'Failed to get the shipping rate try again');
            redirect('home/cart');
            // echo json_encode(array('status' => '0', 'message' => 'Enter the valid zipcode'));
        }
    }

    public function getShippingTime() {
        //create soap request
        $requestoption['RequestOption'] = 'TNT';
        $request['Request'] = $requestoption;

        $addressFrom['City'] = 'Miami';
        $addressFrom['CountryCode'] = 'US';
        $addressFrom['PostalCode'] = '33156';
        $addressFrom['StateProvinceCode'] = 'VE';
        $shipFrom['Address'] = $addressFrom;
        $request['ShipFrom'] = $shipFrom;

        $addressTo['City'] = $this->input->post('city');
        $addressTo['CountryCode'] = $this->input->post('country');
        $addressTo['PostalCode'] = $this->input->post('postcode');
        $addressTo['StateProvinceCode'] = $this->input->post('state');
        $shipTo['Address'] = $addressTo;
        $request['ShipTo'] = $shipTo;
        $pickup['Date'] = date("Ymd", strtotime($this->input->post('pickup_date')));
        $request['Pickup'] = $pickup;

        $unitOfMeasurement['Code'] = 'KGS';
        $unitOfMeasurement['Description'] = 'Kilograms';
        $shipmentWeight['UnitOfMeasurement'] = $unitOfMeasurement;
        $shipmentWeight['Weight'] = '10';
        $request['ShipmentWeight'] = $shipmentWeight;

        $request['TotalPackagesInShipment'] = '1';

        $invoiceLineTotal['CurrencyCode'] = 'CAD';
        $invoiceLineTotal['MonetaryValue'] = '10';
        $request['InvoiceLineTotal'] = $invoiceLineTotal;

        $request['MaximumListSize'] = '1';

        (array) $result = $this->ups_lib->getTransitTime($request);
////        echo "<pre>";
////        print_r($result);
////        die;
//        echo $result->Response->ResponseStatus->Description;
        if ($result->Response->ResponseStatus->Description == 'Success') {
            $output = "<table class='table table-bordered'>";
            $output .= "<tr><th>Code</th>";
            $output .= "<th>Shipping Package</th>";
            $output .= "<th>Arrival Date & time</th>";
            $output .= "<th>No of days</th></tr>";
            foreach ($result->TransitResponse->ServiceSummary as $data) {
                $output .= "<tr><td>" . $data->Service->Code . "</td>";
                $output .= "<td>" . $data->Service->Description . "</td>";
                $output .= "<td>" . $data->EstimatedArrival->DayOfWeek . ', ' . date('d F Y', strtotime($data->EstimatedArrival->Arrival->Date)) . "</td>";
                $output .= "<td>" . $data->EstimatedArrival->TotalTransitDays . "</td></tr>";
            }
            $output .= "</table>";
            echo json_encode(array("status" => "1", "data" => $output));
        } else {
            echo json_encode(array("status" => "0", "data" => $result->detail->Errors->ErrorDetail->PrimaryErrorCode->Description));
        }
    }

    public function TrackOrder() {
        //create soap request
        $req['RequestOption'] = '15';
        $tref['CustomerContext'] = 'Add description here';
        $req['TransactionReference'] = $tref;
        $request['Request'] = $req;
        $request['InquiryNumber'] = '';
        $request['TrackingOption'] = '01';
        $this->ups_lib->getTracking($request);
    }

}
