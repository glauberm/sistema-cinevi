import React from 'react';
import { NavLink } from 'react-router-dom';

import authentication from '../routes/authentication';
import user from '../routes/user';
import booking from '../routes/booking';
import bookable from '../routes/bookable';
import bookableCategory from '../routes/bookable-category';
import project from '../routes/project';
import finalCopy from '../routes/final-copy';
import productionRole from '../routes/production-role';
import productionCategory from '../routes/production-category';
import misc from '../routes/misc';

const menuItems = [
    {
        label: 'Acesso',
        links: [
            {
                to: authentication.profile.path,
                text: 'Sua área',
            },
            // {
            //     to: '/comunidade',
            //     text: 'Comunidade',
            // },
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
                to: user.index.path,
                text: 'Usuários',
            },
            {
                to: misc.configuration.path,
                text: 'Configurações',
            },
        ],
    },
    {
        label: 'Almoxarifado',
        links: [
            {
                to: booking.index.path,
                text: 'Reservas',
            },
            {
                to: bookable.index.path,
                text: 'Reserváveis',
            },
            {
                to: bookableCategory.index.path,
                text: 'Categorias',
            },
        ],
    },
    {
        label: 'Realização',
        links: [
            {
                to: project.index.path,
                text: 'Projetos',
            },
            // {
            //     to: finalCopy.index.path,
            //     text: 'Cópias Finais',
            // },
            {
                to: productionRole.index.path,
                text: 'Funções',
            },
            {
                to: productionCategory.index.path,
                text: 'Modalidades',
            },
        ],
    },
];

export default function Navigation() {
    return (
        <nav className="pt-2 sticky-top vh-100 overflow-auto">
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
