
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
}

export default nd2 = new nd2();

