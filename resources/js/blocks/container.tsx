import { ContainerRoot } from "@narsil-cms/components/container";

type ContainerProps = React.ComponentProps<typeof ContainerRoot> & {};

function Container({ ...props }: ContainerProps) {
  return <ContainerRoot {...props} />;
}

export default Container;
