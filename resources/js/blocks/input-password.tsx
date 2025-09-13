import { useState } from "react";

import { Tooltip } from "@narsil-cms/blocks";
import { Icon } from "@narsil-cms/components/icon";
import { InputContent, InputRoot } from "@narsil-cms/components/input";
import { useLabels } from "@narsil-cms/components/labels";

type InputPasswordProps = Omit<
  React.ComponentProps<typeof InputContent>,
  "children"
> & {};

function InputPassword({ type, ...props }: InputPasswordProps) {
  const { trans } = useLabels();

  const [show, setShow] = useState(false);

  const tooltip = show
    ? trans("accessibility.hide_password")
    : trans("accessibility.show_password");

  return (
    <InputRoot>
      <InputContent type={show ? "text" : type} {...props} />
      <Tooltip tooltip={tooltip}>
        <Icon
          className="cursor-pointer opacity-50 duration-300 hover:opacity-100"
          aria-label={tooltip}
          name={show ? "eye-off" : "eye"}
          onClick={() => setShow(!show)}
        />
      </Tooltip>
    </InputRoot>
  );
}

export default InputPassword;
