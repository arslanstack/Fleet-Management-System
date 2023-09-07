import { withScriptjs, withGoogleMap } from "react-google-maps"
const GoogleMapComponent = withScriptjs(withGoogleMap((props => props.children)));

export default GoogleMapComponent;