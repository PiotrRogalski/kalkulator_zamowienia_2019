
class nd2 {
   validateNumber(value) {
    let regex = /\d+[,.]?(\d*)?/gm;
    let escaped = regex.exec(value);
    if ((value === '') || (escaped === null)) return 0;
    let commasReplaced = escaped[0].replace(/\,/g, '.');
    return commasReplaced;
  }
  formatDate (date) {
    if (!date) return null;
    const [year, month, day] = date.split('-');
    return `${year}/${month}/${day}`
  }
  parseDate (date) {
    if (!date) return null;
    const [year, month, day] = date.split('/');
    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
  }
  openGlassPaneDialog() {EventBus.$emit('openAddGlassPaneDialog');}
  closeGlassPaneDialog() {EventBus.$emit('closeAddGlassPaneDialog');}
  isEmpty(obj) {
    for(var key in obj) {
      if(obj.hasOwnProperty(key))
        return false;
    }
    return true;
  }
  empty(value) {
     let isZero         = (value === 0 || value === '0');
     let isNull         = (value === null);
     let isNullString   = (value === 'null');
     let isBigNull      = (value === 'NULL');
     let isEmptyString  = (value === '');
     let isUndefined    = (typeof value === 'undefined');
     return (isZero || isNull || isNullString || isBigNull || isEmptyString || isUndefined);
  }
  log(val) {
    let obj = {};
    if (typeof val === 'object') {
      obj = val;
      for(let key in obj) {console.log(key + ':' + obj[key]);}
    } else {
      console.log(val);
    }
  }
  validNumber(value, defaultValue = 0, minValue = null, noFloat = false) {
    let matches, match;
    if (typeof defaultValue !== 'number') {defaultValue = 0}
    let number = defaultValue;
    let regexDotAndDigits = /([-]{1})?\d+([.,]{1}\d+)?/;
    let regexOnlyDigits = /([-]{1})?\d+/;
    let regex = regexDotAndDigits;
    if (noFloat === true) {regex = regexOnlyDigits}
    let isNumber = typeof value === 'number';
    let isMinValueNumber = typeof minValue === 'number';
    let isString = typeof value === 'string';
    let isNull = value === null;
    let isMinValueNull = minValue === null;
    if (value === true || value === 'true') {return 1};
    if (value === false || value === 'false') {return 0};

       if (!isNull && isNumber) {number = value;}
       else if (isString) {
         if (value.indexOf(',') > -1) {value = value.replace(',','.');}
         matches = value.match(regex);
         if (matches === null) {match = defaultValue} else {match = matches[0]}
         number = match*1;
       }

       if (isMinValueNumber && !isMinValueNull && (number < minValue)) {
         number = minValue;
       }

   return number;
  }
  validNumberTest() {
     let testValues   = ['12', 12, 'sa32', '21%', '^%@67.21,4', 67.1, -56, '-64', 'fs-21,2', 0, false, true, 'true', 'false', null, undefined, 'null', 'NULL', '', 'undefined', [], {}, !!+2, {id: 2, name: 'sd'}, [1,2,3]];
     let expectValues = [ 12,  12,   32,    21,       67.21,    67.1, -56,  -64,     -21.2,  0,   0,     1,     1,     0,      0,       0,        0,      0,    0,      0,       0,  0,  1,            0,             0   ];
    let result;
    let resultErrors = [];
    for (let testId in testValues) {
      result = this.validNumber(testValues[testId]);
      if (result !== expectValues[testId]) {
        let message = 'TEST: '+testId+'. Expect: '+expectValues[testId]+' but get: '+result;
        resultErrors.push(message);
      }
    }
    if (resultErrors.length > 0) {console.log(resultErrors);} else {console.log('validNumber() - test ok');}
  }
  length(array) {
    let result = 0;
    if (typeof array === 'array' || typeof array === 'string') {
      result = array.length;
    }
    return result;
  }
  showErrorDialog(err) {EventBus.$emit('showErrorDialog', err);}

}

export default nd2 = new nd2();

