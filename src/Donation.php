<?php

namespace Cruk\EventSdk;

class Donation extends EWSObject
{
    /**
     * id
     *
     * @var integer
     */
    private $id;

    /**
     * amount
     *
     * @var float
     */
    private $amount;

    /**
     * bankAccountCode
     *
     * @var string
     */
    private $bankAccountCode;

    /**
     * dataSource
     *
     * @var string
     */
    private $dataSource;

    /**
     * dateReceived
     *
     * @var string
     */
    private $dataRecevied;

    /**
     * donationType
     *
     * @var string
     */
    private $donationType;

    /**
     * financialPaymentReference
     *
     * @var string
     */
    private $financialPaymentReference;

    /**
     * paymentMethod
     *
     * @var string
     */
    private $paymentMethod;

    /**
     * paymentStatus
     *
     * @var string
     */
    private $paymentStatus;

    /**
     * personalGiftAid
     *
     * @var boolean
     */
    private $personalGiftAid;

    /**
     * product
     *
     * @var string
     */
    private $product;

    /**
     * source
     *
     * @var string
     */
    private $source;

    /**
     * originalPaymentId
     *
     * @var string
     */
    private $originalPaymentId;

    /**
     * toBeGiftAided
     *
     * @var boolean
     */
    private $toBeGiftAided;

    /**
     * paymentProviderTransactionId
     *
     * @var string
     */
    private $paymentProviderTransactionId;

    /**
     * event
     *
     * @var Event
     */
    private $event;

    /**
     * registration
     *
     * @var Registration
     */
    private $registration;

    /**
     * Donation constructor.
     * @param EWSClient $client
     * @param $data
     * @param Event $event
     * @param Registration $registration
     */
    public function __construct(EWSClient $client, $data, Event $event, Registration $registration)
    {
        $this->event = $event;
        $this->registration = $registration;
        parent::__construct($client, $data);
        return $this;
    }


    /**
     * Simple function to return the idKey of a class. This allows us to use
     * a common populate function across all objects/classes.
     *
     * @return string
     */
    protected function getIdKey()
    {
        return 'id';
    }

    /**
     * Simple function to return the URI that should be used to GET this object
     * from the EWS.
     *
     * @return string
     */
    protected function getUri()
    {
        return $this->client->getPath() . "/events/{$this->event->getEventCode()}/registrations/{$this->registration->getRegistrationId()}/donations/{$this->id}.json";
    }

    /**
     * Simple function to return the URI that should be used to POST/UPDATE this object
     * from the EWS.
     *
     * @return string
     */
    protected function getCreateUri()
    {
        return $this->client->getPath() . "/events/{$this->event->getEventCode()}/registrations/{$this->registration->getRegistrationId()}/donations.json";
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
            'id',
            'amount',
            'bankAccountCode',
            'dataSource',
            'dateReceived',
            'donationType',
            'financialPaymentReference',
            'paymentMethod',
            'paymentStatus',
            'personalGiftAid',
            'product',
            'source',
            'originalPaymentId',
            'toBeGiftAided',
            'paymentProviderTransactionId',
        ];
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getBankAccountCode()
    {
        return $this->bankAccountCode;
    }

    /**
     * @param string $bankAccountCode
     */
    public function setBankAccountCode($bankAccountCode)
    {
        $this->bankAccountCode = $bankAccountCode;
    }

    /**
     * @return string
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * @param string $dataSource
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @return string
     */
    public function getDataRecevied()
    {
        return $this->dataRecevied;
    }

    /**
     * @param string $dataRecevied
     */
    public function setDataRecevied($dataRecevied)
    {
        $this->dataRecevied = $dataRecevied;
    }

    /**
     * @return string
     */
    public function getDonationType()
    {
        return $this->donationType;
    }

    /**
     * @param string $donationType
     */
    public function setDonationType($donationType)
    {
        $this->donationType = $donationType;
    }

    /**
     * @return string
     */
    public function getFinancialPaymentReference()
    {
        return $this->financialPaymentReference;
    }

    /**
     * @param string $financialPaymentReference
     */
    public function setFinancialPaymentReference($financialPaymentReference)
    {
        $this->financialPaymentReference = $financialPaymentReference;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @param string $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * @return boolean
     */
    public function getPersonalGiftAid()
    {
        return $this->personalGiftAid;
    }

    /**
     * @param boolean $personalGiftAid
     */
    public function setPersonalGiftAid($personalGiftAid)
    {
        $this->personalGiftAid = $personalGiftAid;
    }

    /**
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getOriginalPaymentId()
    {
        return $this->originalPaymentId;
    }

    /**
     * @param string $originalPaymentId
     */
    public function setOriginalPaymentId($originalPaymentId)
    {
        $this->originalPaymentId = $originalPaymentId;
    }

    /**
     * @return boolean
     */
    public function getToBeGiftAided()
    {
        return $this->toBeGiftAided;
    }

    /**
     * @param boolean $toBeGiftAided
     */
    public function setToBeGiftAided($toBeGiftAided)
    {
        $this->toBeGiftAided = $toBeGiftAided;
    }

    /**
     * @return mixed
     */
    public function getPaymentProviderTransactionId()
    {
        return $this->paymentProviderTransactionId;
    }

    /**
     * @param mixed $paymentProviderTransactionId
     */
    public function setPaymentProviderTransactionId($paymentProviderTransactionId)
    {
        $this->paymentProviderTransactionId = $paymentProviderTransactionId;
    }


}
