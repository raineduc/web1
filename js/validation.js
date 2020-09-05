export const isNumber = (number) => !(typeof number !== 'number' && isNaN(parseFloat(number)));

/**
 * 
 * @param {Array} numbers 
 * @return {boolean}
 */
export const areNumbers = (numbers) => numbers.every(isNumber);

export const getNumber = (value) => typeof value === 'number' ? value : parseFloat(value);

/**
 * 
 * @param {Array} values
 * @returns {Array.<Number>}
 */
export const getNumbers = (values) => values.map(getNumber);

export const checkIfRadiusValid = (radius) => isNumber(radius) && radius >= 0;

export const isYCoordInValidRange = (coord) => coord > -3 && coord < 5;