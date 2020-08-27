import { checkIfRadiusValid, isNumber } from '../validation.js';

const gameForm = document.documentElement.querySelector('.game-form');

const radiusInput = gameForm.querySelector('.game-form__radius');
const coordsInputs = gameForm.querySelectorAll('.game-form__coord');



gameForm.addEventListener('submit', (e) => {
  for (let coordInput of coordsInputs) {
    const wrapper = coordInput.closest('.game-form__input-wrapper');

    if (!validateCoordinate(wrapper, coordInput.value)) {
      e.preventDefault();
    }
  }

  const radiusInputWrapper = radiusInput.closest('.game-form__input-wrapper');

  if (!validateRadius(radiusInputWrapper, radiusInput.value)) {
    e.preventDefault();
  }
});

Array.from(coordsInputs).forEach(input => {
  input.addEventListener('blur', (e) => {
    if (isNumber(input.value)) removeError(input.closest('.game-form__input-wrapper'));
  });
});

radiusInput.addEventListener('blur', (e) => {
  if (isNumber(radiusInput.value) && checkIfRadiusValid(radiusInput.value)) {
    removeError(radiusInput.closest('.game-form__input-wrapper'));
  }
})




const addError = (wrapper, message) => {
  wrapper.classList.add('game-form__input-wrapper_error');
  const error = wrapper.querySelector('.game-form__input-error') || document.createElement('span');
  if (!wrapper.querySelector('.game-form__input-error')) {
    error.className = 'game-form__input-error';
    wrapper.appendChild(error);
  }
  error.textContent = message;
}

const removeError = (wrapper) => {
  wrapper.classList.remove('game-form__input-wrapper_error');
  const error = wrapper.querySelector('.game-form__input-error');
  if (error) error.remove();
}

const validateCoordinate = (wrapper, value) => {
  if (isNumber(value)) {
    removeError(wrapper);
    return true;
  }
  addError(wrapper, "В поле введено не число");
  return false;
}

const validateRadius = (wrapper, value) => {
  if (isNumber(value)) {
    if (checkIfRadiusValid(value)) {
      removeError(wrapper);
      return true;
    }
    addError(wrapper, "Радиус не может быть отрицательным");
  } else {
    addError(wrapper, "В поле введено не число");
  }
  return false;
}