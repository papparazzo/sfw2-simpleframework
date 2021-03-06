<?php

/**
 *  SFW2 - SimpleFrameWork
 *
 *  Copyright (C) 2017  Stefan Paproth
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

namespace SFW2\Core;

use ArrayAccess;
use SFW2\Core\Container\Exception as ContainerException;

class Container implements ArrayAccess {
    protected array $data = [];

    public function __construct(array $data = []) {
        $this->insert($data);
    }

    public function offsetExists(string $offset): bool {
        return isset($this->data[$offset]);
    }

    public function offsetGet(string $offset) {
        if(!isset($this->data[$offset])) {
            throw new ContainerException('Offset "' . $offset . '" not set ');
        }
        return $this->data[$offset];
    }

    public function offsetSet(string $offset, $value) : void {
        if(is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset(string $offset) : void {
        unset($this->data[$offset]);
    }

    protected function insert(array $items) : array {
        foreach($items as $key => $item) {
            if(is_array($item)) {
                $this->data[$key] = new self($item);
                continue;
            }
            $this->data[$key] = $item;
        }
    }
}
