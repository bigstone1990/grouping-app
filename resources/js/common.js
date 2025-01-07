const isEmpty = (obj) => {
  return Object.keys(obj).length === 0
}

const customDateToString = (date) => {
  let year = date.getFullYear();
  let month = String(date.getMonth() + 1).padStart(2, '0');
  let day = String(date.getDate()).padStart(2, '0');
  
  return `${year}-${month}-${day}`;
}

export { isEmpty, customDateToString }
