import dayjs from 'dayjs';
import isLeapYear from 'dayjs/plugin/isLeapYear';
import 'dayjs/locale/pt-br';

dayjs.locale('pt-br');

/**
 * Constrói um objeto de Data através de uma string.
 *
 * @param {string} datetime
 * @returns Date
 */
function buildDateObj(datetime) {
    return dayjs(datetime).toDate();
}

/**
 * Constrói uma string formatada de data.
 *
 * @export
 * @param {string} datetime
 * @returns string
 */
export function getDate(datetime) {
    const datetimeObj = buildDateObj(datetime);

    const date = `0${datetimeObj.getDate()}`.slice(-2);
    const month = `0${datetimeObj.getMonth() + 1}`.slice(-2);
    const year = datetimeObj.getFullYear();

    return `${date}/${month}/${year}`;
}

/**
 * Constrói uma string formatada de hora.
 *
 * @export
 * @param {string} datetime
 * @returns string
 */
export function getTime(datetime) {
    const datetimeObj = buildDateObj(datetime);

    const hours = `0${datetimeObj.getHours()}`.slice(-2);
    const minutes = `0${datetimeObj.getMinutes()}`.slice(-2);
    const seconds = `0${datetimeObj.getSeconds()}`.slice(-2);

    return `${hours}:${minutes}:${seconds}`;
}

/**
 * Constrói uma string formatada de data e hora.
 *
 * @export
 * @param {string} datetime
 * @returns string
 */
export function getDatetime(datetime) {
    return `${getDate(datetime)} ${getTime(datetime)}`;
}
