import axios, { AxiosError, AxiosResponse } from 'axios';

import authentication from '../routes/authentication';
import { reboot } from './auth';

interface ValidationErrorResponseData {
    errors: Array<string[]> | Array<Array<string[]>> | Array<Array<Array<string[]>>>;
}

interface UndefinedErrorResponseData {
    message: string;
}

/**
 * Gera uma instância do Axios com a URL base da API
 */
const api = axios.create({ baseURL: process.env.MIX_APP_BASE_API_URL });

/**
 * Reinicia o app ao encontrar um resposta não autenticada, exceto na página de login
 */
api.interceptors.response.use(undefined, (error) => {
    if (
        error.response &&
        error.config &&
        error.response.status === 401 &&
        error.config.url !== authentication.login.path
    ) {
        reboot(error.config.url);
    }

    return Promise.reject(error);
});

/**
 * Retorna mensagens para os erros das requisições.
 *
 * @export
 * @param {AxiosError} error
 * @returns string
 */
export function handleError(error: AxiosError) {
    if (process.env.NODE_ENV === 'development') {
        if (typeof error.toJSON === 'function') {
            console.error(error.toJSON());
        } else {
            console.error(error);
        }
    }

    const response: AxiosResponse<unknown, any> | undefined = error.response;

    if (response !== undefined) {
        /**
         * The request was made and the server responded with a status code that falls out of the range of 2xx
         */
        switch (response.status) {
            case 422:
                const validationError = <ValidationErrorResponseData | undefined>response.data;

                if (validationError !== undefined) {
                    const errors = Object.values(validationError.errors)[0];

                    if (Array.isArray(errors[0])) {
                        return errors[0][0];
                    }

                    return errors[0];
                }

                return 'Há erros no formulário.';
            case 404:
                return 'Nenhum resultado encontrado.';
            case 429:
                return 'Muitas requisições. Tente novamente em um minuto.';
            case 500:
                return 'Erro no servidor. A falha foi registrada.';
            default:
                const undefinedError = <UndefinedErrorResponseData | undefined>response.data;

                if (undefinedError !== undefined) {
                    return undefinedError.message;
                }

                return 'Ocorreu um erro. A falha foi registrada.';
        }
    } else if (error.request !== undefined) {
        /**
         * The request was made but no response was received `error.request` is an instance of XMLHttpRequest in the
         * browser and an instance of http.ClientRequest in node.js
         */
        return 'Erro ao receber resposta, por favor tente novamente.';
    } else {
        /**
         * Something happened in setting up the request that triggered an Error
         */
        return 'Ocorreu um erro inesperado, por favor tente atualizar a página.';
    }
}

export default api;
