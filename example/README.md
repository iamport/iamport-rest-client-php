# Example Guide

* * *

## 용어설명
- imp_uid : 아임포트에서 자동 생성하는 주문 아이디입니다.
  - 아임포트에서는 중복되지 않는 고유값으로 이 값을 생성합니다.
  
- merchant_uid : 고객사에서 생성하는 주문 아이디입니다.
  - merchant_uid는 고유값이 아니어도 괜찮습니다.
  - 예제에서 소개하는 방법을 사용하면, merchant_uid이 중복되었을 때 목록을 검색하는 할 수 있습니다.

- 빌링키 : 정기결제/예약결제 사용 시 PG사로 부터 발급 받는 키 입니다.
  - 자세한 설명은 [아임포트 정기결제 메뉴얼](https://docs.iamport.kr/implementation/subscription?lang=ko)을 참고해주세요.
  - 빌링키 결제는 다른 말로 비인증 결제라고도 합니다. (인증없이, 키만으로 결제가 가능하기 때문)


***

## Example 목록 및 설명

<table class="tg">
<thead>
  <tr>
    <th class="tg-0pky">예제 파일명</th>
    <th class="tg-0pky">구분</th>
    <th class="tg-0pky">예제 설명</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td class="tg-0pky">example_cancel.php</td>
    <td class="tg-0pky">주문환불</td>
    <td class="tg-0pky">imp_uid를 통한환불 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_escrow_register_logis.php</td>
    <td class="tg-0pky">에스크로</td>
    <td class="tg-0pky">imp_uid를 통해 에스크로 결제건에 대한 배송정보를 등록 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_escrow_update_logis.php</td>
    <td class="tg-0pky">에스크로</td>
    <td class="tg-0pky">imp_uid를 통해 에스크로 결제건에 대한 배송정보를 수정 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_get_by_imp_uid.php</td>
    <td class="tg-0pky">주문정보</td>
    <td class="tg-0pky">imp_uid를 통한주문정보 불러오기 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_get_by_merchant_uid.php</td>
    <td class="tg-0pky">주문정보</td>
    <td class="tg-0pky">merchant_uid를 통한주문정보 불러오기 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_get_certification_by_imp_uid.php</td>
    <td class="tg-0pky">본인인증</td>
    <td class="tg-0pky">imp_uid를 통한본인인증 정보 불러오기 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_get_receipt.php</td>
    <td class="tg-0pky">현금영수증</td>
    <td class="tg-0pky">imp_uid를 통한현금영수증 번호 및 URL 등 정보 불러오기 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_issue_receipt.php</td>
    <td class="tg-0pky">현금영수증</td>
    <td class="tg-0pky">imp_uid를 통한현금영수증 발행 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_issue_vbank.php</td>
    <td class="tg-0pky">가상계좌</td>
    <td class="tg-0pky">merchant_uid를 통한가상계좌 발행 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_list_by_merchant_uid.php</td>
    <td class="tg-0pky">주문목록</td>
    <td class="tg-0pky">merchant_uid를 통한 주문목록 검색 예제<br>(merchant_uid는 중복될 수 있습니다.)</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_modify_vbank.php</td>
    <td class="tg-0pky">가상계좌</td>
    <td class="tg-0pky">imp_uid를 통한 가상계좌 변경 예제<br>(입금 금액, 임금기한을 수정할 수 있습니다.)</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_revoke_vbank.php</td>
    <td class="tg-0pky">가상계좌</td>
    <td class="tg-0pky">imp_uid를 통해 기존 발행 된 가상계좌를 말소 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_sbcr_again.php</td>
    <td class="tg-0pky">비인증결제</td>
    <td class="tg-0pky">빌링키를 이용한 결제(재결제) 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_sbcr_customers_DELETE.php</td>
    <td class="tg-0pky">비인증결제</td>
    <td class="tg-0pky">기존 발행 된 빌링키를 삭제하는 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_sbcr_customers_GET.php</td>
    <td class="tg-0pky">비인증결제</td>
    <td class="tg-0pky">기존 발행 된 빌링키 정보를 얻는 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_sbcr_customers_POST.php</td>
    <td class="tg-0pky">비인증결제</td>
    <td class="tg-0pky">빌링키를 수정하거나 등록하는 예제<br><strong>하단 주의사항 1 필독!! **</strong></td>
  </tr>
  <tr>
    <td class="tg-0pky">example_schedule_by_cardinfo.php</td>
    <td class="tg-0pky">비인증결제</td>
    <td class="tg-0pky">카드정보를 통한 예약결제/정기결제 스케쥴을 추가 예제<br><strong>하단 주의사항 1 필독!! **</strong></td>
  </tr>
  <tr>
    <td class="tg-0pky">example_schedule_by_billinkey.php</td>
    <td class="tg-0pky">비인증결제</td>
    <td class="tg-0pky">빌링키를 이용하여 예약결제/정기결제 스케쥴을 추가 예제</td>
  </tr>
  <tr>
    <td class="tg-0pky">example_unschedule.php</td>
    <td class="tg-0pky">비인증결제</td>
    <td class="tg-0pky">빌링키를 이용하여 예약된 결제 스케쥴을 삭제 예제</td>
  </tr>
</tbody>
</table>

* * *

# 주의사항
- 주의사항 1)
  - 주) Rest API를 통한 빌링키 발행을 지원하는 PG에서 사용 가능한 예제입니다.
  - 주) Rest API 방식을 지원하는 PG는 현재 '나이스정보통신'입니다.
  - 주) 그 이외의 PG사를 이용하실 경우 [이 메뉴얼](https://docs.iamport.kr/implementation/subscription?lang=ko)을 따라 일반결제창을 통해 빌링키를 발급해야 합니다.
  
 