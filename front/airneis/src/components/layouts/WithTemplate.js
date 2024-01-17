import Template from "./Template"

function WithTemplate(Component) {
    return (
        <Template>
            <Component />
        </Template>
    )
}

export default WithTemplate;