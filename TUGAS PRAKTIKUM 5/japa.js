const buttons = document.querySelectorAll('main button')
const resultDisplay = document.getElementById('result')

let value1 = '0'
let nextValue = '';
let operator = '';
let result = '';


buttons.forEach(  (button) => {
  button.addEventListener('click', () => {
      const value = button.textContent.trim()

      if(!isNaN(value)){
        if(value1 === '0') {
          value1 = value
        }else {
          value1 += value
        }
      }else if(value === 'C'){
        let value1 = '0'
        let nextValue = '';
        operator = '';
        result = '';
      }else if(value === '=') {
        if(nextValue !== '') {
          calculate()
        }
      }else {
        if(nextValue !== ''){
          calculate()
        }

        nextValue = value1
        operator = value;
        value1 = '0'

      }
      updateResult()
  })

})


function calculate() {

    const current = parseFloat(value1)
    const prev = parseFloat(nextValue)

    switch (operator) {
      case '+':
        result = prev + current
        break;
      case '-':
        result = prev - current
        break;
      case 'x':
        result = prev * current
        break;
      case '/':
        if(value1 !== 0) {
          result = prev / current
        }else {
          result = 'Infinity'
        }
        break;
    
      default:
        break;
    }
    value1 = result.toString()
    nextValue = ''
    result = ''
}

function updateResult() {
  resultDisplay.textContent = value1
}