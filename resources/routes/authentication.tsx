import React from 'react';

import AuthenticationLoginPage from '../pages/Authentication/AuthenticationLoginPage';
import AuthenticationLogoutPage from '../pages/Authentication/AuthenticationLogoutPage';
import AuthenticationProfilePage from '../pages/Authentication/AuthenticationProfilePage';

export default {
    login: { path: '/entrada', element: <AuthenticationLoginPage /> },
    logout: { path: '/saida', element: <AuthenticationLogoutPage /> },
    profile: { path: '/', element: <AuthenticationProfilePage /> },
    // requestForgotPassword: { path: '/esqueci-minha-senha', element: <AuthenticationForgotPasswordPage /> },
    // requestUpdateEmail: {
    //     path: '/solicitar-atualizar-email',
    //     element: <AuthenticationRequestUpdateEmailPage />,
    // },
    // resetPassword: { path: '/redefinir-senha', element: <AuthenticationResetPasswordPage /> },
    // updateEmail: { path: '/atualizar-email', element: <AuthenticationUpdateEmailPage /> },
    // updatePassword: { path: '/atualizar-senha', element: <AuthenticationUpdatePasswordPage /> },
};
