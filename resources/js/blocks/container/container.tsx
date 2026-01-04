import { ContainerRoot } from "@narsil-cms/components/container";
import { type ComponentProps } from "react";

type ContainerProps = ComponentProps<typeof ContainerRoot>;

function Container({ ...props }: ContainerProps) {
  return <ContainerRoot {...props} />;
}

export default Container;
