import { Link as InertiaLink, InertiaLinkProps } from "@inertiajs/react";
import { ComponentProps } from "react";

type ExternalLinkProps = ComponentProps<"a">;
type InternalLinkProps = InertiaLinkProps;

type LinkProps = ExternalLinkProps | InternalLinkProps;

function isExternalLinkProps(props: LinkProps): props is ExternalLinkProps {
  return props.target === "_blank";
}

function Link(props: LinkProps) {
  return isExternalLinkProps(props) ? (
    <a {...props} />
  ) : (
    <InertiaLink {...props} />
  );
}

export default Link;
