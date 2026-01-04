import { KbdGroup, KbdRoot } from "@narsil-cms/components/kbd";
import { Fragment, type ComponentProps } from "react";

type KbdProps = ComponentProps<typeof KbdGroup> & {
  elements: string[];
};

function Kbd({ ...props }: KbdProps) {
  return (
    <KbdGroup {...props}>
      {props.elements.map((element, index) => {
        return (
          <Fragment key={index}>
            <KbdRoot>{element}</KbdRoot>
            {index !== props.elements.length - 1 ? <span>+</span> : null}
          </Fragment>
        );
      })}
    </KbdGroup>
  );
}

export default Kbd;
