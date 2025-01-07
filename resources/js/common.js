const nl2br = (str) => {
  str = str.replace(/\r\n/g, "<br />");
  str = str.replace(/(\n|\r)/g, "<br />");
  return str;
}

const isEmpty = (obj) => {
  return Object.keys(obj).length === 0
}

const customDateToString = (date) => {
  let year = date.getFullYear();
  let month = String(date.getMonth() + 1).padStart(2, '0');
  let day = String(date.getDate()).padStart(2, '0');
  
  return `${year}-${month}-${day}`;
}

const customDateStringToJP = (date) => {
  const dateUTC = new Date(date + 'T00:00:00Z');
  let year = dateUTC.getFullYear();
  let month = String(dateUTC.getMonth() + 1).padStart(2, '0');
  let day = String(dateUTC.getDate()).padStart(2, '0');
  
  return `${year}年${month}月${day}日`;
}

export { nl2br, isEmpty, customDateToString, customDateStringToJP }
