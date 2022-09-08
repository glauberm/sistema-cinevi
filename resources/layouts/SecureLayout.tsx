import React, { useEffect, useState } from 'react';

import BaseLayout from './BaseLayout';
import Navigation from '../components/Navigation';

export default function SecureLayout(props) {
    const [isMenuActive, setMenuActive] = useState(true);

    useEffect(() => {
        if (isMenuActive) {
            document.documentElement.classList.remove('is-menu-inactive');
            document.documentElement.classList.add('is-menu-active');
        } else {
            document.documentElement.classList.remove('is-menu-active');
            document.documentElement.classList.add('is-menu-inactive');
        }

        return () => {
            document.documentElement.classList.remove('is-menu-active');
            document.documentElement.classList.remove('is-menu-inactive');
        };
    }, [isMenuActive]);

    const toggleMenu = () => {
        setMenuActive(!isMenuActive);
    };

    return (
        <BaseLayout>
            <div className="row">
                <div className="d-none d-xl-block d-xxl-block col-xl-3">
                    <Navigation />
                </div>
                <div className="col-xl-9">
                    <div className="h-100 p-md-5 p-sm-4 p-3 mb-5 bg-body rounded-3">{props.children}</div>
                </div>
            </div>
        </BaseLayout>
    );
}
