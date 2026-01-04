import { HeadingRoot } from "@narsil-cms/components/heading";
import { type ComponentProps } from "react";

type HeadingProps = ComponentProps<typeof HeadingRoot>;

function Heading({ ...props }: HeadingProps) {
  return <HeadingRoot {...props} />;
}

export default Heading;
