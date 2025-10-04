import { type ComponentProps } from "react";

import { ContainerRoot } from "@narsil-cms/components/container";

type ContainerProps = ComponentProps<typeof ContainerRoot>;

function Container({ ...props }: ContainerProps) {
  return <ContainerRoot {...props} />;
}

export default Container;
