import React, { createContext } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import axios, { AxiosError, AxiosResponse } from 'axios';

import authentication from '../routes/authentication';

type ValidationErrorResponseData = {
    errors: Array<string[]> | Array<Array<string[]>> | Array<Array<Array<string[]>>>;
};

type UndefinedErrorResponseData = {
    message: string;
};

export const ApiContext = createContext(undefined);

export default function ApiProvider(props) {
    const { pathname } = useLocation();
    const navigate = useNavigate();

    const api = axios.create({ baseURL: process.env.MIX_APP_BASE_API_URL });

    api.interceptors.response.use(undefined, (error) => {
        if (error.response && error.config && error.response.status === 401 && error.config.url !== '/entrada') {
            navigate(authentication.login.path, { state: { redirectTo: pathname } });
        }

        return Promise.reject(error);
    });

    return <ApiContext.Provider value={{ api }}>{props.children}</ApiContext.Provider>;
}

/**
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

    const response: AxiosResponse | undefined = error.response;

    if (response !== undefined) {
        /**
         * The request was made and the server responded with a status code that falls out of the range of 2xx
         */
        switch (response.status) {
            case 422:
                const validationError: ValidationErrorResponseData | undefined = response.data;

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
            case 405:
                return 'Método de requisição incorreto.';
            case 429:
                return 'Muitas requisições. Tente novamente em 15 minutos.';
            case 500:
                return 'Erro no servidor. A falha foi registrada.';
            default:
                const undefinedError: UndefinedErrorResponseData | undefined = response.data;

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
