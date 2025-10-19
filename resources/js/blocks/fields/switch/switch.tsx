import { SwitchRoot, SwitchThumb } from "@narsil-cms/components/switch";
import { type ComponentProps } from "react";

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
