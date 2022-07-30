import authentication from '../routes/authentication';
import { NotificationsContextInterface } from '../contexts/NotificationsProvider';

const IS_AUTHENTICATED_KEY = 'is_authenticated';

const REBOOTED_KEY = 'reboot_message';

const REBOOT_MESSAGE = 'A sua chave de autenticação precisa ser renovada. Por favor, entre novamente.';

/**
 * Define a chave que informa se o cliente web está autenticado.
 *
 * @export
 * @param {boolean} isAuthenticated
 */
export function setAuthenticated(isAuthenticated: boolean) {
    localStorage.setItem(IS_AUTHENTICATED_KEY, isAuthenticated === true ? '1' : '0');
}

/**
 * Retorna se o cliente web está autenticado.
 *
 * @export
 * @returns
 */
export function isAuthenticated() {
    return localStorage.getItem(IS_AUTHENTICATED_KEY) === '1' ? true : false;
}

/**
 * Remove o token de autenticação, gera mensagem de reinicialização e reinicia o app.
 *
 * @export
 */
export function reboot(url: string) {
    const urlParams = new URLSearchParams();

    urlParams.append('redirecionar_para', url);
    sessionStorage.setItem(REBOOTED_KEY, '1');
    window.location.href = `${authentication.login.path}?${urlParams}`;
}

/**
 * Notifica sobre a reinicialização do app a um componente.
 *
 * @export
 * @param {NotificationsContextInterface} notifications
 */
export function isRebooted(notifications: NotificationsContextInterface) {
    if (sessionStorage.getItem(REBOOTED_KEY) !== null) {
        notifications.add(REBOOT_MESSAGE, 'info');
        sessionStorage.removeItem(REBOOTED_KEY);
    }
}
