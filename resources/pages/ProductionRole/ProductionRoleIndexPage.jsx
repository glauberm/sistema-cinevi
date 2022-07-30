import React from 'react';
import { Link } from 'react-router-dom';

import Title from '../../components/Title';
import ProductionRoleCollection from '../../collections/ProductionRole/ProductionRoleCollection';

export default function ProductionRoleIndexPage() {
    return (
        <div>
            <Title>Funções</Title>

            <ProductionRoleCollection />

            <hr className="invisible" />

            <Link className="btn btn-primary btn-lg" to="/funcoes/adicionar">
                Adicionar
            </Link>
        </div>
    );
}
