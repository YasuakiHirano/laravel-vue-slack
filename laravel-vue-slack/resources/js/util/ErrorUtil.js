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
      let key = Object.keys(error.response.data)[0]
      errorMessage = error.response.data[key][0]
    }
  } else {
    errorMessage = 'システムに障害が発生しました。しばらく待って、もう一度実行してください。';
  }
  return errorMessage
}
