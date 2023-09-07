import config from "../_config";

const ImageHelper = {
    getImageURL: function (image) {
        return image ? image.includes("http") || image.includes("base64") ? image
        : config.baseUrl + image : "https://www.tibs.org.tw/images/default.jpg";
    }
}
export default ImageHelper;