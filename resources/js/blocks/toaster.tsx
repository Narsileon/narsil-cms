import { type ComponentProps } from "react";

import { ToasterRoot } from "@narsil-cms/components/toaster";

type ToasterProps = ComponentProps<typeof ToasterRoot>;

function Toaster({ ...props }: ToasterProps) {
  return <ToasterRoot {...props} />;
}

export default Toaster;
