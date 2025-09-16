import { ToasterRoot } from "@narsil-cms/components/toaster";

type ToasterProps = React.ComponentProps<typeof ToasterRoot> & {};

function Toaster({ ...props }: ToasterProps) {
  return <ToasterRoot {...props} />;
}

export default Toaster;
