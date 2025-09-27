import { type ComponentProps } from "react";

import { SwitchRoot, SwitchThumb } from "@narsil-cms/components/switch";

type SwitchProps = ComponentProps<typeof SwitchRoot> & {
  thumbProps?: Partial<ComponentProps<typeof SwitchThumb>>;
};

function Switch({ thumbProps, ...props }: SwitchProps) {
  return (
    <SwitchRoot {...props}>
      <SwitchThumb {...thumbProps} />
    </SwitchRoot>
  );
}

export default Switch;
