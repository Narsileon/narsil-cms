import { ToasterRoot } from "@narsil-cms/components/toaster";
import { type ComponentProps } from "react";

type ToasterProps = ComponentProps<typeof ToasterRoot>;

function Toaster({ ...props }: ToasterProps) {
  return <ToasterRoot {...props} />;
}

export default Toaster;
