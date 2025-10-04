import { type ComponentProps } from "react";

import { SeparatorRoot } from "@narsil-cms/components/separator";

type SeparatorProps = ComponentProps<typeof SeparatorRoot>;

function Separator({ ...props }: SeparatorProps) {
  return <SeparatorRoot {...props} />;
}

export default Separator;
