<?php

/**
 * libraryUtils
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class libraryUtils
{
    /**
     * @const PASSWORD_SALT_KEY
     */
    const PASSWORD_SALT_KEY = '31a522cfbba9f95f277e';

    /**
     * sortByDate
     * Sort a multidimensional array by date using usort.
     * @param array $aData (Passed by reference)
     * @return $aData
     */
    public static function sortByDate(&$aData)
    {
        return usort(
            $aData,
            fn ($aFirstElement, $aSecondElement) =>
            strtotime($aFirstElement['dateRequested']) - strtotime($aSecondElement['dateRequested'])
        );
    }

    /**
     * sanitizeData
     * Method for santizing input data.
     * @param array &$aParams (Passed by reference)
     */
    public static function sanitizeData(&$aParams)
    {
        // Loop thru the array.
        foreach ($aParams as $sKey => $mValues) {
            // Perform htmlspecialchars() function on every values inside $aParams and trim whitespaces.
            if (is_array($mValues)) {
                foreach ($mValues as $iKey => $sValue) {
                    $aParams[$sKey][$iKey] = nl2br(strip_tags(htmlspecialchars(trim($sValue))));
                }
                continue;
            }
            $aParams[$sKey] = nl2br(strip_tags(htmlspecialchars(trim($mValues))));
        }
    }

    /**
     * renameKeys
     * Method for renaming data.
     * @param array &$aParams (Passed by reference)
     * @param array $aKeys
     */
    public static function renameKeys(&$aParams, $aKeys)
    {
        // Loop thru array data for renaming.
        foreach ($aKeys as $sKey => $mValue) {
            if (empty($aParams[$sKey]) === true) {
                continue;
            }
            $aParams[$mValue] = $aParams[$sKey];
            unset($aParams[$sKey]);
        }
    }

    /**
     * generateRandomString
     * Method for generating random string composed of 20 characters.
     */
    public static function generateRandomString()
    {
        return bin2hex(random_bytes(10));
    }

    /**
     * searchKeyByValueInMultiDimensionalArray
     * @return mixed
     */
    public static function searchKeyByValueInMultiDimensionalArray($mNeedle, $aHaystack, $sColumnToSearch)
    {
        return array_search($mNeedle, array_column($aHaystack, $sColumnToSearch));
    }

    /**
     * unsetUnnecessaryData
     */
    public static function unsetUnnecessaryData(&$aData, $aColumnsToUnset)
    {
        foreach ($aData as $iDataKey => $aDetails) {
            foreach ($aColumnsToUnset as $sKeyToUnset) {
                unset($aData[$iDataKey][$sKeyToUnset]);
            }
        }
    }

    /**
     * unsetKeys
     */
    public static function unsetKeys(&$aData, $aUnnecessaryData)
    {
        foreach ($aUnnecessaryData as $sKey) {
            unset($aData[$sKey]);
        }
    }

    /**
     * getDayName
     */
    public static function getDayName($sDate)
    {
        return date('l', strtotime($sDate));
    }

    /**
     * moveUploadedFile
     */
    public static function moveUploadedFile($aFile, $sFileName)
    {
        move_uploaded_file($aFile['tmp_name'], UPLOAD . $sFileName);
    }

    /**
     * getRemainingBalance
     */
    public static function toCurrencyFormat($sAmount)
    {
        return 'P' . number_format($sAmount);
    }

    /**
     * formatDate
     */
    public static function formatDate($sDate)
    {
        return date("M. d, Y", strtotime($sDate));
    }

    /**
     * hashPassword
     */
    public static function hashPassword($sPassword)
    {
        return hash('sha512', $sPassword . self::PASSWORD_SALT_KEY);
    }
}
