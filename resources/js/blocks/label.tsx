import { type ComponentProps } from "react";

import { LabelRoot } from "@narsil-cms/components/label";

type LabelProps = ComponentProps<typeof LabelRoot> & {};

function Label({ ...props }: LabelProps) {
  return <LabelRoot {...props} />;
}

export default Label;
