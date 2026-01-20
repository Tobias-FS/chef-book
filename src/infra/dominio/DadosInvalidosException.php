<?php

class DadosInvalidosException extends DominioException {

    private array $problemas = [];

    public static function com( array $problemas ): DadosInvalidosException {
        $e = new DadosInvalidosException();
        $e->setProblemas( $problemas );
        return $e;
    }

    public function setProblemas( array $problemas ): self {
        $this->problemas = $problemas; 
        return $this;
    }

    public function getProblemas() {
        return $this->problemas;
    }
}