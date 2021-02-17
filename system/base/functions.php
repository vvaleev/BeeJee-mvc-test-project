<?php

function escapeData($data)
{
    if (!is_array($data)) {
        return $data;
    }

    foreach ($data as $name => $value) {
        $intVal = (int)$value;

        if ($intVal !== 0) {
            $data[$name] = $intVal;
        } elseif (is_string($value)) {
            $data[$name] = htmlspecialchars($value);
        }
    }

    return $data;
}
