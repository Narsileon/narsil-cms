import { type ComponentProps } from "react";

import { ToggleRoot } from "@narsil-cms/components/toggle";

type ToggleProps = ComponentProps<typeof ToggleRoot> & {};

function Toggle({ ...props }: ToggleProps) {
  return <ToggleRoot {...props} />;
}

export default Toggle;
