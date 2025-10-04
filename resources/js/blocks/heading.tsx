import { type ComponentProps } from "react";

import { HeadingRoot } from "@narsil-cms/components/heading";

type HeadingProps = ComponentProps<typeof HeadingRoot>;

function Heading({ ...props }: HeadingProps) {
  return <HeadingRoot {...props} />;
}

export default Heading;
