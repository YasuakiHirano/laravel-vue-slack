/**
 * エラーのステータスからメッセージを返す
 * @param {object} error サーバーから受け取ったエラー
 */
export const findErrorMessage = (error) => {
  let errorMessage = '';
  if (error.response.status === 422) {
    if (typeof error.response.data === "string") {
      errorMessage = error.response.data
    } else if (typeof error.response.data === "object") {
      if (Object.keys(error.response.data).indexOf("errors") !== -1) {
        let key = Object.keys(error.response.data.errors)[0]
        errorMessage = error.response.data.errors[key][0]
      } else {
        let key = Object.keys(error.response.data)[0]
        errorMessage = error.response.data[key][0]
      }
    }
  } else {
    errorMessage = 'システムに障害が発生しました。しばらく待って、もう一度実行してください。';
  }
  return errorMessage
}
