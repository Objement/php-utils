<?php


namespace Objement\OmPhpUtils\HttpRequests;


use DateTime;
use Exception;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerInvalidDateTimeException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerInvalidEmailException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerInvalidIntegerException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerInvalidStringException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerOutOfDesiredLengthException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerOutOfDesiredRangeException;
use Objement\OmPhpUtils\Exceptions\OmRequestHandlerValueNotInWhiteListException;

class OmRequestHandler implements OmRequestHandlerInterface
{
    /**
     * @var array|null
     */
    private ?array $requestData;


    /**
     * OmRequestHandler constructor.
     * @param array|null $requestData
     */
    public function __construct(?array $requestData)
    {
        $this->requestData = array_map(function ($v) {
            return is_string($v) ? trim($v) : $v;
        }, $requestData);
    }

    /**
     * @param string $name
     * @param array $whiteList
     * @return string|null
     * @throws OmRequestHandlerOutOfDesiredLengthException
     * @throws OmRequestHandlerValueNotInWhiteListException
     */
    public function getStringForWhiteList(string $name, array $whiteList): ?string
    {
        $value = $this->getString($name);

        if (!in_array($value, $whiteList)) {
            throw new OmRequestHandlerValueNotInWhiteListException();
        }

        return $value;
    }

    /**
     * @param string $name
     * @param int|null $minLength
     * @param int|null $maxLength
     * @return string|null
     * @throws OmRequestHandlerOutOfDesiredLengthException
     */
    public function getString(string $name, ?int $minLength = null, ?int $maxLength = null): ?string
    {
        if (!is_string($this->requestData[$name])) {
            throw new OmRequestHandlerInvalidStringException();
        }

        if (empty($this->requestData[$name]) || trim($this->requestData[$name]) === '') {
            return null;
        }

        $value = $this->requestData[$name];

        if (isset($minLength) && mb_strlen($value) < $minLength) {
            throw new OmRequestHandlerOutOfDesiredLengthException();
        }

        if (isset($maxLength) && mb_strlen($value) > $maxLength) {
            throw new OmRequestHandlerOutOfDesiredLengthException();
        }

        return $value;
    }

    /**
     * @param string $name
     * @param int|null $min
     * @param int|null $max
     * @return int|null
     * @throws OmRequestHandlerInvalidIntegerException
     * @throws OmRequestHandlerOutOfDesiredRangeException
     */
    public function getInt(string $name, ?int $min = null, ?int $max = null): ?int
    {
        if (!isset($this->requestData[$name]) || trim($this->requestData[$name]) === '') {
            return null;
        }

        $value = filter_var($this->requestData[$name], FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
        if ($value === false) {
            throw new OmRequestHandlerInvalidIntegerException();
        }

        if (isset($min) && $value < $min) {
            throw new OmRequestHandlerOutOfDesiredRangeException();
        }

        if (isset($max) && $value > $max) {
            throw new OmRequestHandlerOutOfDesiredRangeException();
        }

        return (int)$value;
    }

    public function getBool(string $name): ?bool
    {
        if (!isset($this->requestData[$name])) {
            return null;
        }

        $value = filter_var($this->requestData[$name], FILTER_SANITIZE_NUMBER_INT, FILTER_SANITIZE_NUMBER_INT);

        return $value > 0;
    }

    /**
     * @param string $name
     * @param float|null $min
     * @param float|null $max
     * @return float|null
     * @throws OmRequestHandlerInvalidIntegerException
     * @throws OmRequestHandlerOutOfDesiredRangeException
     */
    public function getFloat(string $name, ?float $min = null, ?float $max = null): ?float
    {
        if (!isset($this->requestData[$name]) || trim($this->requestData[$name]) === '') {
            return null;
        }

        $value = filter_var($this->requestData[$name], FILTER_VALIDATE_FLOAT, FILTER_SANITIZE_NUMBER_FLOAT);
        if ($value === false) {
            throw new OmRequestHandlerInvalidIntegerException();
        }

        if (isset($min) && $value < $min) {
            throw new OmRequestHandlerOutOfDesiredRangeException();
        }

        if (isset($max) && $value > $max) {
            throw new OmRequestHandlerOutOfDesiredRangeException();
        }

        return (float)$value;
    }

    /**
     * @param string $name
     * @param DateTime|null $min
     * @param DateTime|null $max
     * @return DateTime|null
     * @throws OmRequestHandlerInvalidDateTimeException
     * @throws OmRequestHandlerOutOfDesiredRangeException
     */
    public function getDateTime(string $name, ?DateTime $min = null, ?DateTime $max = null): ?DateTime
    {
        if (empty($this->requestData[$name]) || trim($this->requestData[$name]) === '') {
            return null;
        }

        try {
            $dateTime = new DateTime($this->requestData[$name]);
        } catch (Exception) {
            throw new OmRequestHandlerInvalidDateTimeException();
        }

        if (isset($min) && $dateTime < $min) {
            throw new OmRequestHandlerOutOfDesiredRangeException();
        }

        if (isset($max) && $dateTime < $max) {
            throw new OmRequestHandlerInvalidDateTimeException();
        }

        return $dateTime;
    }


    /**
     * @param string $name
     * @return string|null
     * @throws OmRequestHandlerInvalidEmailException
     */
    public function getEmail(string $name): ?string
    {
        if (empty($this->requestData[$name]) || trim($this->requestData[$name]) === '') {
            return null;
        }

        $value = filter_var($this->requestData[$name], FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
        if ($value === false) {
            throw new OmRequestHandlerInvalidEmailException();
        }

        return $value;
    }

    public function isSet(string $name): bool
    {
        return isset($this->requestData[$name]);
    }

    /**
     * @param string $groupKeyName
     * @return OmRequestHandler[]
     */
    public function getRequestHandlersForArray(string $groupKeyName): array
    {
        if (isset($this->requestData[$groupKeyName])) {

            return array_map(function ($group) {
                return new self($group);
            }, $this->requestData[$groupKeyName]);
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function getFileInfo(string $name, bool $allowMultiple): OmRequestHandlerFileInfoInterface|array|null
    {
        if (!isset($this->requestData[$name])) {
            trigger_error('You try to get the file info for an uploaded file, but the value is not set. Did you add enctype="multipart/form-data" to the form tag and provide [...$_POST, ...$_FILES]?', E_USER_WARNING);
            return null;
        }

        if ($allowMultiple) {
            $files = $this->requestData[$name];

            $fileInfos = [];
            for ($i = 0; $i < count($files['name']); $i++) {
                if (!is_array($files['name'])) {
                    trigger_error('You try to get the file info for an uploaded file, but it is not an array with name, tmp_name, type and size. Did you add enctype="multipart/form-data" to the form tag and provide [...$_POST, ...$_FILES]?', E_USER_WARNING);
                    return null;
                }

                if (!empty($files['error'][$i]) || $files['error'][$i] != UPLOAD_ERR_OK) {
                    return null;
                }

                $fileInfos[] = new OmRequestHandlerFileInfo(
                    $files['name'][$i],
                    $files['tmp_name'][$i],
                    $files['type'][$i],
                    $files['size'][$i]
                );
            }

            return $fileInfos;
        } else {
            if (!is_array($this->requestData[$name])) {
                trigger_error('You try to get the file info for an uploaded file, but it is not an array with name, tmp_name, type and size. Did you add enctype="multipart/form-data" to the form tag and provide [...$_POST, ...$_FILES]?', E_USER_WARNING);
                return null;
            }

            if (!empty($this->requestData[$name]['error']) || $this->requestData[$name]['error'] != UPLOAD_ERR_OK) {
                return null;
            }

            return new OmRequestHandlerFileInfo(
                $this->requestData[$name]['name'],
                $this->requestData[$name]['tmp_name'],
                $this->requestData[$name]['type'],
                $this->requestData[$name]['size']
            );
        }
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function getArray(string $name): ?array
    {
        if (empty($this->requestData[$name]) || !is_array($this->requestData[$name])) {
            return null;
        }

        return $this->requestData[$name];
    }
}
