import React from 'react';

import AuthenticationLoginPage from '../pages/Authentication/AuthenticationLoginPage';
import AuthenticationLogoutPage from '../pages/Authentication/AuthenticationLogoutPage';
import AuthenticationProfilePage from '../pages/Authentication/AuthenticationProfilePage';
import AuthenticationRequestResetPasswordPage from '../pages/Authentication/AuthenticationRequestResetPasswordPage';
import AuthenticationResetPasswordPage from '../pages/Authentication/AuthenticationResetPasswordPage';
import AuthenticationRegisterPage from '../pages/Authentication/AuthenticationRegisterPage';

export default {
    login: { path: '/entrada', element: <AuthenticationLoginPage /> },
    logout: { path: '/saida', element: <AuthenticationLogoutPage /> },
    register: { path: '/cadastro', element: <AuthenticationRegisterPage /> },
    requestResetPassword: { path: '/recuperacao-de-senha', element: <AuthenticationRequestResetPasswordPage /> },
    // requestUpdateEmail: {
    //     path: '/solicitar-atualizar-email',
    //     element: <AuthenticationRequestUpdateEmailPage />,
    // },
    resetPassword: { path: '/redefinir-senha', element: <AuthenticationResetPasswordPage /> },
    // updateEmail: { path: '/atualizar-email', element: <AuthenticationUpdateEmailPage /> },
    // updatePassword: { path: '/atualizar-senha', element: <AuthenticationUpdatePasswordPage /> },
    profile: { path: '/', element: <AuthenticationProfilePage /> },
};
