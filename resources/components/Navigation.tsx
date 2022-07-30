import React from 'react';
import { NavLink } from 'react-router-dom';

import authentication from '../routes/authentication';
import productionRole from '../routes/production-role';

const menuItems = [
    {
        label: 'Acesso',
        links: [
            {
                to: authentication.profile.path,
                text: 'Seu índice',
            },
            {
                to: authentication.logout.path,
                text: 'Saída',
            },
        ],
    },
    {
        label: 'Sistema',
        links: [
            {
                to: '/usuarios',
                text: 'Usuários',
            },
            {
                to: '/configuracoes',
                text: 'Configurações',
            },
        ],
    },
    {
        label: 'Almoxarifado',
        links: [
            {
                to: '/reservas',
                text: 'Reservas',
            },
            {
                to: '/reservaveis',
                text: 'Reserváveis',
            },
            {
                to: '/categorias',
                text: 'Categorias',
            },
        ],
    },
    {
        label: 'Realização',
        links: [
            {
                to: '/projetos',
                text: 'Projetos',
            },
            {
                to: '/copias-finais',
                text: 'Cópias Finais',
            },
            {
                to: productionRole.index.path,
                text: 'Funções',
            },
            {
                to: 'modalidades',
                text: 'Modalidades',
            },
        ],
    },
];

export default function Navigation() {
    return (
        <nav className="mb-5">
            {menuItems.map((item, key) => (
                <div key={key} className="card mb-4">
                    <div className="card-header text-secondary bg-warning bg-gradient" aria-expanded="false">
                        <strong>{item.label}</strong>
                    </div>
                    <div className="list-group list-group-flush">
                        {item.links.map((link, key) => (
                            <NavLink
                                key={key}
                                to={link.to}
                                className={({ isActive }) =>
                                    isActive
                                        ? 'ps-4 list-group-item list-group-item-action active'
                                        : 'ps-4 list-group-item list-group-item-action text-primary'
                                }
                            >
                                {link.text}
                            </NavLink>
                        ))}
                    </div>
                </div>
            ))}
        </nav>
    );
}
