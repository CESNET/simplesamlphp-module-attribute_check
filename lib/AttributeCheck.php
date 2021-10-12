<?php

declare(strict_types=1);

namespace SimpleSAML\Module\attribute_check;

class AttributeCheck
{
    public const MANDATORY_ONE = 'MANDATORY_AT_LEAST_ONE';

    public const MANDATORY_ALL = 'MANDATORY_ALL';

    public const OPTIONAL = 'OPTIONAL';

    public const OK = 'OK';

    public const NOT_OK = 'NOT_OK';

    public static function handleAttributesGroup($t, $conf, $attributes): string
    {
        $translates = $conf['translates'];
        $type = $conf['type'];

        if (! in_array($type, [self::MANDATORY_ONE, self::MANDATORY_ALL, self::OPTIONAL], true)) {
            throw new \SimpleSAML\Error\Exception('AttributeSP: Bad type!');
        }

        $title = self::translate($t, $translates, 'title');
        $description = self::translate($t, $translates, 'description');

        $group_attributes = $conf['attribute_list'];
        if (! is_array($group_attributes)) {
            throw new \SimpleSAML\Error\Exception('Attributes must be an array!');
        }

        $result = self::getGroupResult($type, $group_attributes, $attributes);

        $resultTitle = self::translate($t, $translates[$result], 'title');
        $resultDescription = self::translate($t, $translates[$result], 'description');

        return "<div class='alert " . self::getAlertClass(
            $type,
            $result
        ) . "'><strong>" . $title . '</strong> - ' . $resultTitle . '<br/><br/>' . $resultDescription . '</div>';
    }

    private static function translate($t, $translates, $key): string
    {
        if ($translates === null) {
            throw new \SimpleSAML\Error\Exception('Translation configuration cannot be null!');
        }

        if (isset($translates[$key])) {
            return $t->getTranslation($translates[$key]);
        }

        return '';
    }

    private static function getGroupResult($type, array $group_attributes, $attributes): string
    {
        if (in_array($type, [self::MANDATORY_ONE, self::OPTIONAL], true)) {
            foreach ($group_attributes as $item) {
                if (is_string($item)) {
                    if (array_key_exists($item, $attributes)) {
                        return self::OK;
                    }
                } elseif (is_array($item)) {
                    foreach ($item as $listItem) {
                        if (! array_key_exists($item, $attributes)) {
                            return self::NOT_OK;
                        }
                    }
                    return self::OK;
                }
            }
            return self::NOT_OK;
        }
        foreach ($group_attributes as $item) {
            if (is_string($item)) {
                if (! array_key_exists($item, $attributes)) {
                    return self::NOT_OK;
                }
            } elseif (is_array($item)) {
                foreach ($item as $listItem) {
                    if (! array_key_exists($item, $attributes)) {
                        return self::NOT_OK;
                    }
                }
            }
        }
        return self::OK;
    }

    private static function getAlertClass($type, $result): string
    {
        if (in_array($type, [self::MANDATORY_ONE, self::MANDATORY_ALL], true)) {
            if ($result === self::OK) {
                return 'alert-success';
            }
            return 'alert-danger';
        }
        if ($result === self::OK) {
            return 'alert-success';
        }
        return 'alert-warning';
    }
}
