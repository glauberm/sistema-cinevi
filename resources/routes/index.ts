import authentication from './authentication';
import misc from './misc';
import productionRole from './production-role';

export const secureRoutes = [
    authentication.logout,
    authentication.profile,
    // authentication.requestUpdateEmail,
    // authentication.updateEmail,
    // authentication.updatePassword,
    // ...Object.values(productionRole),
    productionRole.create,
    productionRole.update,
    productionRole.index,
];

export const publicRoutes = [
    authentication.login,
    // authentication.requestForgotPassword,
    // authentication.resetPassword,
    misc.notFound,
];
