import { type ComponentProps } from "react";

import { Border } from "@narsil-cms/components/border";
import { SwitchRoot, SwitchThumb } from "@narsil-cms/components/switch";

type SwitchProps = ComponentProps<typeof SwitchRoot> & {
  thumbProps?: Partial<ComponentProps<typeof SwitchThumb>>;
};

function Switch({ thumbProps, ...props }: SwitchProps) {
  return (
    <SwitchRoot {...props}>
      <Border />
      <SwitchThumb {...thumbProps} />
    </SwitchRoot>
  );
}

export default Switch;
