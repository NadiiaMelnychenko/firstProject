
const convertBigintToDate = (date) => {
  return Math.floor(new Date(date).getTime() / 1000);
}

export default convertBigintToDate;