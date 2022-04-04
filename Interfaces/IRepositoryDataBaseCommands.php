<?php

interface IRepositoryDataBaseCommands {
    public function query(string $query);
    public function injection(string $query, string $types, &$var, &...$vars);
    public function last_insert_id();
    public function last_error();
}