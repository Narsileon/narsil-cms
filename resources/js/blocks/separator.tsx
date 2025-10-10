import { SeparatorRoot } from "@narsil-cms/components/separator";
import { type ComponentProps } from "react";

type SeparatorProps = ComponentProps<typeof SeparatorRoot>;

function Separator({ ...props }: SeparatorProps) {
  return <SeparatorRoot {...props} />;
}

export default Separator;
