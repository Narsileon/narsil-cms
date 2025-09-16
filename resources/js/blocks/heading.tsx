import { HeadingRoot } from "@narsil-cms/components/heading";

type HeadingProps = React.ComponentProps<typeof HeadingRoot> & {};

function Heading({ ...props }: HeadingProps) {
  return <HeadingRoot {...props} />;
}

export default Heading;
