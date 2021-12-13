export const formdata = (raw: any): FormData => {
  const data = new FormData();
  Object.keys(raw).forEach((key) => {
    const value = raw[key];
    data.append(key, typeof value === 'object' ? JSON.stringify(raw[key]) : raw[key]);
  });

  return data;
};
