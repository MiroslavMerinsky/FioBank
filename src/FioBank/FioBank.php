<?php

namespace Merinsky\FioBank;

/**
 * FioBank
 *
 * @author Miroslav Merinsky <miroslav@merinsky.biz>
 * @version 1.0 
 */
class FioBank {

    /** @var string */
    private $apiKey = null;

    /** @var string */
    private $apiUrl = 'https://www.fio.cz/ib_api/rest';

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey) {
        if (empty($apiKey))
            throw new \InvalidArgumentException('Invalid argument has been entered.');

        $this->apiKey = $apiKey;
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     */
    public function getBankStatement(\DateTime $from, \DateTime $to) {
        $from = $from->format('Y-m-d');
        $to = $to->format('Y-m-d');

        $data = $this->call("periods/$this->apiKey/$from/$to/transactions.json");

        if (!isset($data['accountStatement']['transactionList']['transaction'])
            && !is_array($data['accountStatement']['transactionList']['transaction']))
            return [];

        $v = [];

        foreach ($data['accountStatement']['transactionList']['transaction'] as $item) {
            $v[] = [
                'id' => isset($item['column22']['value']) ? $item['column22']['value'] : null,
                'date' => isset($item['column0']['value']) ? $item['column0']['value'] : null,
                'amount' =>  isset($item['column1']['value']) ? $item['column1']['value'] : null,
                'currency' => isset($item['column14']['value']) ? $item['column14']['value'] : null,
                'bank-account' => isset($item['column2']['value']) ? $item['column2']['value'] : null,
                'bank-account-name' => isset($item['column10']['value']) ? $item['column10']['value'] : null,
                'bank-code' => isset($item['column3']['value']) ? $item['column3']['value'] : null,
                'bank-name' => isset($item['column12']['value']) ? $item['column12']['value'] : null,
                'ks' => isset($item['column4']['value']) ? $item['column4']['value'] : null,
                'vs' => isset($item['column5']['value']) ? $item['column5']['value'] : null,
                'ss' => isset($item['column6']['value']) ? $item['column6']['value'] : null,
                'description' => isset($item['column7']['value']) ? $item['column7']['value'] : null,
                'note' => isset($item['column16']['value']) ? $item['column16']['value'] : null,
                'type' => isset($item['column8']['value']) ? $item['column8']['value'] : null,
                'person' => isset($item['column9']['value']) ? $item['column9']['value'] : null,
                'comment' => isset($item['column25']['value']) ? $item['column25']['value'] : null,
                'bank-dic' => isset($item['column26']['value']) ? $item['column26']['value'] : null,
                'id-item' => isset($item['column17']['value']) ? $item['column17']['value'] : null,
            ];
        }

        return $v;
    }

    /**
     * @param string $request
     * @param array $data
     * @return array
     */
    private function call($request, array $data = []) {
        if (empty($request))
            throw new \InvalidArgumentException('Invalid argument has been entered.');

        $r = curl_init();
        curl_setopt($r, CURLOPT_URL, "$this->apiUrl/$request");
        curl_setopt($r, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($r, CURLOPT_HEADER, false);
        if (!empty($data)) {
            curl_setopt($r, CURLOPT_POST, true);
            curl_setopt($r, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($r,CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $response = curl_exec($r);
        curl_close($r);

        return json_decode($response, true);
    }


}